<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'budget_head' => new BudgetHeadResource($this->budgetHead),
            'reference' => $this->reference,
            'due_date' => $this->due_date->format('d F, Y'),
            'amount' => $this->amount,
            'currency' => $this->currency,
            'description' => $this->description,
            'status' => $this->status,
            'completed' => $this->completed ? 'Yes' : 'No'
        ];
    }
}
