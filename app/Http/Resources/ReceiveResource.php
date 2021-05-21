<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiveResource extends JsonResource
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
        return [
            'id' => $this->id,
            'identifier' => $this->identifier,
            'benefactor' => $this->receiveable->member->getFullname(),
            'beneficiary' => $this->receiveable,
            'type' => $this->receiveable_type
        ];
    }
}
