<?php

namespace App\Http\Resources;

use App\Models\Category;
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
            'created_at' => $this->created_at->format('d M, Y')
        ];
    }
}
