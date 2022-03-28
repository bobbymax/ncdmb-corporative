<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
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
            'budget_head_code' => $this->budgetHead->code,
            'budget_head_name' => $this->budgetHead->description,
            'description' => $this->description,
            'approved_amount' => $this->approved_amount,
            'booked_expenditure' => $this->booked_expenditure,
            'actual_expenditure' => $this->actual_expenditure,
            'booked_balance' => $this->booked_balance,
            'actual_balance' => $this->actual_balance,
            'expected_performance' => $this->expected_performance,
            'actual_performance' => $this->actual_performance,
            'exhausted' => $this->exhausted ? 'Yes' : 'No',
            'year' => $this->year
        ];
    }
}
