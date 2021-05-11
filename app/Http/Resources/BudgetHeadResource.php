<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetHeadResource extends JsonResource
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
            'budget' => new BudgetResource($this->budget),
            'description' => $this->description,
            'category' => $this->category,
            'interest' => $this->interest,
            'restriction' => $this->restriction,
            'commitment' => $this->commitment,
            'limit' => $this->limit,
            'payable' => $this->payable,
            'frequency' => $this->frequency,
            'type' => $this->type,
            'fund' => $this->fund,
            'active' => $this->active ? 'Yes' : 'No',
            'created_at' => $this->created_at->format('d F, Y')
        ];
    }
}
