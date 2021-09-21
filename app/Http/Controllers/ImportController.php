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
            'data' => 'required',
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
                $this->result = $this->membersBulkAdd($request->data);
                break;
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

    protected function membersBulkAdd(array $data)
    {
        foreach($data as $value) {
            $member = User::where('membership_no', $value['membership_no'])->first();
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
                    'email' => $email,
                    'type' => 'member',
                    'password' => Hash::make($pass),
                ]);

                $contribution = Contribution::create([
                    'user_id' => $member->id,
                    'month' => $today->month,
                    'fee' => $value['current_contribution'],
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
                        'max_slots' => 1000,
                        'start_date' => Carbon::now(),
                        'cannot_expire' => 1,
                    ]);
                }

                $member->actAs($role);
            }

            $this->bulkRecords[] = $member;
        }

        return $this->bulkRecords;
    }
}
