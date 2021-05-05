<?php

namespace App\Http\Resources;

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
            'owner' => new UserResource($this->member),
            'budget_head' => new BugetHeadResource($this->fund),
            'created_at' => $this->created_at->format('d M, Y'),
            'closed' => $this->closed ? 'Yes' : 'No',
            'schedules' => ScheduleResource::collection($this->schedules),
            'guarantors' => $this->guarantors,
            'status' => $this->status
        ];
    }
}
