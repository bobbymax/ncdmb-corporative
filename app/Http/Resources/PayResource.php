<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayResource extends JsonResource
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
            'initiator' => new UserResource($this->initiator),
            'trxRef' => $this->trxRef,
            'title' => $this->title,
            'amount' => $this->amount,
            'beneficiary' => new BeneficiaryResource($this->beneficiary),
            'payable' => $this->payable,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d F, Y')
        ];
    }
}
