<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstructionResource extends JsonResource
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
            'user_id' => $this->loan->user_id,
            'loan_id' => $this->loan_id,
            'budget_head_id' => $this->loan->budget_head_id,
            'budgetName' => $this->loan->fund->description,
            'loanAmount' => $this->loan->amount,
            'capital' => $this->capital,
            'deduction' => $this->installment,
            'interest' => $this->interest,
            'interestSum' => $this->interestSum,
            'balance' => $this->remain,
            'due_month' => $this->due->format('F'),
            'due_year' => $this->due->format('Y'),
            'due' => $this->due->format('d F, Y'),
            'fulfilled' => $this->paid == 1,
            'loanStatus' => $this->loan->status,
            'frequency' => $this->loan->fund->frequency,
            'source' => $this->loan->fund->payable
        ];
    }
}
