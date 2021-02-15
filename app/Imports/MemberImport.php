<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Contribution;
use App\Models\Kin;
use App\Models\Wallet;
use App\Models\Role;
use Illuminate\Support\Facades\Hash as Encrypt;
use App\Http\Resources\UserResource;
// use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;

class MemberImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        {
            $member = new User([
                'firstname' => $this->name($row[0])['first'],
                'middlename' => $this->name($row[0])['middle'],
                'surname' => $this->name($row[0])['surname'],
                'staff_no' => $row[1],
                'designation' => $row[2],
                'email' => $row[3],
                'mobile' => $row[4],
                'location' => $row[5],
                'date_joined' => Carbon::parse($row[6]),
                'type' => $row[7],
                'password' => Encrypt::make('Password1'),
            ]);

            $contribution = Contribution::create([
                'user_id' => $member->id,
                'fee' => $row[8]
            ]);

            $kin = Kin::create([
                'user_id' => $member->id,
                'name' => $row[10],
                'relationship' => $row[11],
                'mobile' => $row[12],
                'address' => $row[13],
            ]);

            $wallet = Wallet::create([
                'user_id' => $member->id,
                'identifier' => Str::random(12),
                'bank_name' => $row[14],
                'account_number' => $row[15]
            ]);

            $role = Role::where('label', 'member')->first();

            if (!$role) {
                $role = Role::create([
                    'name' => 'Member',
                    'label' => 'member',
                    'slots' => 1000
                ]);
            }

            $role->members()->save($member);
        }

        $members = User::latest()->get();

        return $members;
    }

    protected function name($str)
    {
        $sname = explode(",", $str);
        $surname = $sname[0];
        $others = explode(" ", $sname[1]);
        $first = $others[0];
        $middle = isset($others[1]) ? $others[1] : null;

        return compact('first', 'middle', 'surname');
    }
}
