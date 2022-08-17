<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'account_code_id' => $this->account_code_id,
            'chart_of_account_id' => $this->chart_of_account_id,
            'budget_head_id' => $this->budget_head_id,
            'disbursement_id' => $this->disbursement_id,
            'amount' => $this->amount,
            'description' => $this->description,
            'payment_methods' => $this->payment_methods,
            'entries' => $this->entries,
            'paid' => $this->paid == 1,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
