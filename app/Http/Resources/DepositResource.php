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
            'transaction' => $this->trxRef,
            'amount' => $this->amount,
            'status' => $this->paid == 1 ? "paid" : "pending",
            'type' => $this->transactions !== null ? $this->transactions->type : null,
            'created' => $this->created_at->format('d F, Y')
        ];
    }
}
