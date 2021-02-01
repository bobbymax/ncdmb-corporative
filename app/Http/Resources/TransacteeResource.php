<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransacteeResource extends JsonResource
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
            'type' => $this->type,
            'status' => $this->status,
            // 'transaction'=> new TransactionResource($this->transaction)
        ];
    }
}
