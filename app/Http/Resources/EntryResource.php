<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'accountCode' => $this->journal->accountType->name,
            'chartOfAccountName' => $this->journal->chartOfAccount->name,
            'chartOfAccountCode' => $this->journal->chartOfAccount->code,
            'purpose' => $this->journal->description,
            'journal_id' => $this->journal_id,
            'payment_type' => $this->payment_type,
            'payment_methods' => $this->journal->payment_methods,
            'amount' => $this->payment_type === "debit" ? "-" . $this->amount : $this->amount,
            'description' => $this->description,
            'paid' => $this->journal->paid == 1 ? "Paid" : "Pending",
            'created_at' => $this->created_at->format('d F, Y'),
            'updated_at' => $this->updated_at->format('d F, Y')
        ];
    }
}
