<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'user_id' => $this->user_id,
            'service_category_id' => $this->service_category_id,
            'code' => $this->code,
            'category' => $this->category->name,
            'label' => $this->category->label,
            'fields' => $this->field,
            'controller' => new UserResource($this->member),
            //'contribution' => $this->member->contributions,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d F, Y')
        ];
    }
}
