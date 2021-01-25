<?php

namespace App\Http\Resources;

use App\Models\Guarantor;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class GuarantorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $loan_code = Loan::where('code', $this->code)->pluck('id');
        $guarantors = Guarantor::where('loan_id', $loan_code)->pluck('user_id');
        $users = "";
        $arr = collect([]);

        for ($i = 0; $i < count($guarantors); $i++) {
            $users = User::find($guarantors[$i]);
            // array_push($arr, $users);
            $arr->push($users);
        }

        return [
            count($arr) < 1 ? null : $arr,
            // 'firstname' => $this->firstname,
            // 'lastname' => $this->lastname,
            // 'middlename' => $this->middlename
        ];
    }
}
