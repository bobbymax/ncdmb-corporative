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
            'user_id' => $this->user_id,
            'budget_head_id' => $this->budget_head_id,
            'code' => $this->code,
            'amount' => $this->amount,
            'capitalSum' => $this->capitalSum,
            'committment' => $this->committment,
            'interestSum' => $this->interestSum,
            'totalPayable' => $this->totalPayable,
            'reason' => $this->reason,
            'description' => $this->description,
            'owner' => new UserResource($this->member),
            'name' => $this->member->firstname . " " . $this->member->surname,
            'budget_head' => new BudgetHeadResource($this->fund),
            'budget_head_name' => $this->fund->description,
            'created_at' => $this->created_at,
            'closed' => $this->closed ? 'Yes' : 'No',
            // 'schedules' => ScheduleResource::collection($this->schedules),
            'instructions' => $this->instructions,
            'sponsors' => GuarantorResource::collection($this->sponsors),
            'level' => $this->level,
            'stage' => $this->stage,
            'status' => $this->status,
            'active' => $this->active == 1 ? true : false
        ];
    }
}
