<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanCategoryResource extends JsonResource
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
            'budget_head_code' => $this->head->code,
            'budget_head' => $this->head->title,
            'budget_head_amount' => $this->head->amount,
            'name' => $this->name,
            'label' => $this->label,
            'description' => $this->description,
            'amount' => $this->amount,
            'interest_rate' => $this->interest,
            'restriction' => $this->restriction,
            'committment' => $this->committment,
            'limit' => $this->limit,
            'payable' => $this->payable,
            'frequency' => $this->frequency,
            'created_at' => $this->created_at->format('d F, Y')
        ];
    }
}
