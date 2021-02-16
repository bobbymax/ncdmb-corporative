<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BugetHeadResource extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'budget' => new BudgetResource($this->budget),
            'created_at' => $this->created_at->format('d F, Y')
        ];
    }
}
