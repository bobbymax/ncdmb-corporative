<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DisbursementResource extends JsonResource
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
            'user_id' => $this->user_id,
            'controllerName' => $this->controller->firstname . " " . $this->controller->surname,
            'controller' => new UserResource($this->controller),
            'budget_head_id' => $this->budget_head_id,
            'budgetHeadName' => $this->budgetHead->name,
            'budgetHeadCode' => $this->budgetHead->code,
            'chart_of_account_id' => $this->chart_of_account_id,
            'chartOfAccountCode' => $this->chartOfAccount->code,
            'chartOfAccountName' => $this->chartOfAccount->name,
            'payment_type' => $this->payment_type,
            'type' => $this->type,
            'code' => $this->code,
            'beneficiary' => $this->beneficiary,
            'loan_id' => $this->loan_id,
            'batch_id' => $this->bundle_id,
            'description' => $this->description,
            'amount' => $this->amount,
            'status' => $this->status,
            'closed' => $this->closed == 1 ? true : false,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
