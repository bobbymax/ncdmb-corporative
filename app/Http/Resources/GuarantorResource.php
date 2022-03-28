<?php

namespace App\Http\Resources;

use App\Models\Guarantor;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class GuarantorResource extends JsonResource
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
            'loan_id' => $this->loan_id,
            'user_id' => $this->user_id,
            'code' => $this->sponsored->code,
            'beneficiary' => $this->sponsored->member->firstname . " " . $this->sponsored->member->surname,
            'amount' => $this->sponsored->amount,
            'reason' => $this->sponsored->reason,
            // 'loan' => new LoanResource($this->sponsored),
            'member' => new UserResource($this->member),
            'remark' => $this->remark,
            'status' => $this->status
        ];
    }
}
