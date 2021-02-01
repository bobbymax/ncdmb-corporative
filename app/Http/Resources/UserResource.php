<?php

namespace App\Http\Resources;

use App\Models\Loan;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // parent::toArray($request);

        return [
            'id' => $this->id,
            'membership_no' => $this->membership_no,
            'staff_no' => $this->staff_no,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'surname' => $this->surname,
            'email' => $this->email,
            'designation' => $this->designation,
            'type' => $this->type,
            'date_joined' => $this->date_joined->format('d M, Y'),
            'mobile' => $this->mobile,
            'isActivated' => $this->membership_no !== null ? true : false,
            'location' => $this->location,
            'address' => $this->address,
            'contribution' => isset($this->contribution) ? $this->contribution->only('fee') : null,
            'next_of_kin' => isset($this->kin) ? $this->kin->only('name', 'relationship', 'mobile') : null,
            'wallet' => isset($this->wallet) ? $this->wallet->only(['identifier', 'current', 'deposit', 'available', 'ledger', 'account_number', 'bank_name']) : null,
            'roles' => RoleResource::collection($this->roles),
            'can_guarantee' => $request->user()->guaranteed()->wherePivot('status', 'approved')->get()->count() >= 2 ? false : true,
            // 'can_loan' => Loan::where('id', auth()->user())->where('status', 'disbursed')->get()->last() !== null ?
            //     (Loan::where('id', auth()->user())->where('status', 'disbursed')->get()->last()->count() > 0
            //         ? true
            //         : false)
            //     : 0
        ];
    }
}
