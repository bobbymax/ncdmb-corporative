<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Contribution;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use App\Mail\WelcomeMail;
use Mail;
use DB;

class ImportController extends Controller
{
    protected $bulkRecords = [];
    protected $result;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required|array',
            'type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'danger',
                'message' => 'Please fix errors'
            ], 500);
        }

        switch ($request->type) {
            case "members" :
                $this->result = $this->fireMembersUpload($request->data);
                break;
            case "credit-members" :
                $this->result = $this->creditMembersWallet($request->data);
            case "update-contributions" :
                $this->result = $this->updateMemberContributions($request->data);
            default :
                $this->result = [];
                break;
        }

        return response()->json([
            'data' => $this->result,
            'status' => 'success',
            'message' => 'Imported successfully!!'
        ], 200);
    }

    protected function creditMembersWallet(array $data)
    {
        foreach($data as $user) {
            $member = User::where('staff_no', $user['membership_no'])->first();

            if ($member) {
                $member->wallet->current += $user['amount'];
                $member->wallet->save();
            }

            $this->bulkRecords[] = $member;
        }

        return $this->bulkRecords;
    }

    protected function fireMembersUpload(array $data)
    {
        $this->importMembersRecords($data);
        $this->importMembersContributions($data);
        $this->importMembersWallets($data);
        return $this->addRolesToMembers($data);
    }

    protected function importMembersRecords(array $data)
    {
        $dataChunk = [];

        foreach($data as $value) {
            $member = User::where("membership_no", $value['membership-no'])->first();

            if (! $member) {
                $email = strtolower($value['firstname']).".".strtolower($value['surname'])."@ncdmb.gov.ng";
                $pass = strtolower($value['firstname']).".".strtolower($value['surname']);

                $insertData = [
                    'firstname' => $value['firstname'],
                    'middlename' => isset($value['middlename']) ? $value['middlename'] : null,
                    'surname' => $value['surname'],
                    'staff_no' => $value['membership-no'],
                    'membership_no' => $value['membership-no'],
                    'email' => isset($value['email']) && $value['email'] !== "" ? $value['email'] : $email,
                    'type' => 'member',
                    'password' => Hash::make($pass),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $dataChunk[] = $insertData;
            }
        }

        $dataChunk = collect($dataChunk);
        $chunks = $dataChunk->chunk(100);
        return $this->insertInto('users', $chunks);
    }

    protected function importMembersContributions(array $data)
    {
        $dataChunk = [];

        foreach($data as $value) {
            $member = User::where("membership_no", $value['membership-no'])->first();

            if ($member) {
                $insertData = [
                    'user_id' => $member->id,
                    'month' => Carbon::now()->format('F'),
                    'fee' => isset($value['current-contribution']) ? $value['current-contribution'] : 0,
                    'current' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $dataChunk[] = $insertData;
            }
        }

        $dataChunk = collect($dataChunk);
        $chunks = $dataChunk->chunk(100);
        return $this->insertInto('contributions', $chunks);
    }

    protected function updateLoanStatus(array $data) {
        //
    }

    protected function updateMemberContributions(array $data) {
        $dataChunk = [];

        foreach($data as $value) {
            $member = User::where("membership_no", $value['membership-no'])->first();

            if ($member) {
                $member->wallet->update([
                    'current' => $value['total-contribution'],
                    'available' => $value['total-contribution']
                ]);

                $recent = Contribution::where('user_id', $member->id)->where('current', true)->first();

                if ($recent) {
                    $recent->update([
                        'current' => false
                    ]);

                    Contribution::create([
                        'user_id' => $member->id,
                        'fee' => $value['contribution-fee'] ?? 0,
                        'month' => 'October',
                        'current' => true
                    ]);
                }

                $dataChunk[] = $member;
            }
        }

        return $dataChunk;
    }

    protected function importMembersWallets(array $data)
    {
        $dataChunk = [];

        foreach($data as $value) {
            $member = User::where("membership_no", $value['membership-no'])->first();

            if ($member) {
                $insertData = [
                    'user_id' => $member->id,
                    'identifier' => Hash::make($member->firstname),
                    'current' => $value['total-contribution'],
                    'available' => $value['total-contribution'],
                    'ledger' => $value['total-contribution'],
                    'bank_name' => "Dummy",
                    'account_number' => uniqid() . time(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                $dataChunk[] = $insertData;
            }
        }

        $dataChunk = collect($dataChunk);
        $chunks = $dataChunk->chunk(100);
        return $this->insertInto('wallets', $chunks);
    }

    protected function addRolesToMembers(array $data)
    {
        $role = Role::where("label", "member")->first();

        if (! $role) {
            $role = Role::create([
                'name' => 'Member',
                'label' => 'member',
                'slots' => 1000
            ]);
        }

        foreach($data as $value) {
            $member = User::where("membership_no", $value['membership-no'])->first();

            if ($member) {
                $member->actAs($role);
            }
        }

        return $role;
    }

    protected function membersBulkAdd(array $data)
    {
        foreach($data as $value) {
            $member = User::where('membership_no', $value['membership-no'])->first();
            $today = Carbon::now();

            if (! $member) {
                $email = strtolower($value['firstname']).".".strtolower($value['surname'])."@ncdmb.gov.ng";
                $pass = strtolower($value['firstname']).".".strtolower($value['surname']);
                $member = User::create([
                    'staff_no' => $value['membership_no'],
                    'membership_no' => $value['membership_no'],
                    'firstname' => ucfirst(strtolower($value['firstname'])),
                    'surname' => ucfirst(strtolower($value['surname'])),
                    'middlename' => isset($value['middlename']) ? ucfirst(strtolower($value['middlename'])) : null,
                    'email' => $value['email'] ?? $email,
                    'type' => 'member',
                    'password' => Hash::make($pass),
                ]);

                $contribution = Contribution::create([
                    'user_id' => $member->id,
                    'month' => $today->month,
                    'fee' => isset($value['current_contribution']) ? $value['current_contribution'] : 0,
                    'current' => true
                ]);

                if (! $member->wallet) {
                    $wallet = Wallet::create([
                        'user_id' => $member->id,
                        'identifier' => Hash::make($member->firstname),
                        'current' => $value['wallet_balance'],
                        'bank_name' => "Dummy",
                        'account_number' => uniqid() . time()
                    ]);
                }

                $role = Role::where('label', 'member')->first();

                if (! $role) {
                    $role = Role::create([
                        'name' => 'Member',
                        'label' => 'member',
                        'slots' => 1000
                    ]);
                }

                $member->actAs($role);

                Mail::to($member->email)->queue(new WelcomeMail($member));
            }

            $this->bulkRecords[] = $member;
        }

        return $this->bulkRecords;
    }

    protected function insertInto($table, $chunks)
    {
        foreach ($chunks as $chunk) {
            DB::table($table)->insert($chunk->toArray());
        }

        return;
    }
}
