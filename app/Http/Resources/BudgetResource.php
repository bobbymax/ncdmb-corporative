<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
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
            'title' => $this->title,
            'code' => $this->code,
            'amount' => $this->amount,
            'period' => $this->period,
            'status' => $this->status,
            'active' => $this->active == 1 ? true : false
        ];
    }
}
