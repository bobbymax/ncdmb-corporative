<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'amount' => $this->amount,
            'status' => $this->status,
            'completed' => $this->completed,
            'date_created' => $this->created_at->format('d F, Y'),
            'members'=> TransacteeResource::collection($this->transactees)
        ];
    }
}
