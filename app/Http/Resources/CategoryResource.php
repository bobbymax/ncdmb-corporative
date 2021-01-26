<?php

namespace App\Http\Resources;

use App\Models\Expenditure;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'label' => $this->label,
            'description' => $this->description,
            'module' => $this->module,
            'fundable' => $this->fundable == 1 ? true : false,
            'isLoan' => $this->isLoan == 1 ? true : false,
            'interest' => $this->interest,
            'frequency' => $this->frequency,
            'restriction' => $this->restriction,
            'payable' => $this->payable,
            'limit' => $this->limit,
            'committment' => $this->committment,
            'created_at' => $this->created_at->format('d M, Y'),
            'hasExpenditure' => (Expenditure::find($this->id)) > 0 ? true : false
        ];
    }
}
