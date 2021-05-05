<?php

namespace App\Http\Resources\Extras;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "id" => $this->id,
            "staff_no" => $this->staff_no,
            "membership_no" => $this->membership_no ?? null,
            "loans" => LoanResource::collection($this->loans->where('closed', false))
        ];
    }
}
