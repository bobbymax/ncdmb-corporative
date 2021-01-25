<?php

namespace App\Http\Resources;

use App\Models\Guarantor;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'amount' => $this->amount,
            'reason' => $this->reason,
            'description' => $this->description,
            'frequency' => $this->frequency,
            'status' => $this->status,
            'member' => UserResource::collection($this->member),
            'category' => $this->category,
            'created_at' => $this->created_at->format('d M, Y'),
            'closed' => $this->closed == 1 ? true : false,
            'schedules' => ScheduleResource::collection($this->schedules),
            'guarantors' => new GuarantorResource($this)
        ];
    }
}
