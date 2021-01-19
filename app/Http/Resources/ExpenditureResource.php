<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenditureResource extends JsonResource
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
            'title' => $this->title,
            'label' => $this->label,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'status' => $this->status,
            'budget' => new BudgetResource($this->budget),
            'category' => new CategoryResource($this->category),
            'closed' => $this->closed == 1 ? true : false
        ];
    }
}
