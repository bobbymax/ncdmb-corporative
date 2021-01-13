<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\ContributionResource;

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
            'contribution' => $this->contribution,//->only('fee'),
            'next of kin' => $this->kin,//->only('name', 'relationship', 'mobile'),
            'wallet' => $this->wallet//->only(['identifier', 'current', 'available', 'ledger']),
            'roles' => RoleResource::collection($this->roles),
        ];
    }
}
