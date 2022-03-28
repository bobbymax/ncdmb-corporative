<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContributionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'user_id' => $this->member->id,
            'fee' => $this->fee,
            'member' => new UserResource($this->member),
            'month' => $this->month,
            'current' => $this->current == 1 ? true : false,
            'name' => $this->member->firstname . " " . $this->member->surname,
            'membership_no' => $this->member->membership_no,
            'isAdministrator' => $this->member->isAdministrator == 1 ? true : false
        ];
    }
}
