<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
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
            'member' => new UserResource($this->member),
            'trxRef' => $this->trxRef,
            'amount' => $this->amount,
            'status' => $this->paid == 1 ? true : false,
            'created' => $this->created_at->format('d F, Y') 
        ];
    }
}
