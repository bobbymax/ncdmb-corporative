<?php

namespace App\Http\Resources;

use App\Models\Loan;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // parent::toArray($request);

        $outstanding = Loan::where('status', 'disbursed')->latest()->get();

        return [
            'id' => $this->id,
            'membership_no' => $this->membership_no,
            'staff_no' => $this->staff_no,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'surname' => $this->surname,
            'email' => $this->email,
            'designation' => $this->designation ?? null,
            'type' => $this->type,
            'date_joined' => $this->date_joined != null ? $this->date_joined->format('d M, Y') : null,
            'mobile' => $this->mobile ?? null,
            'isActivated' => $this->membership_no !== null,
            'location' => $this->location ?? null,
            'running_loan_amount' => $this->runningLoans->sum('amount'),
            'address' => $this->address ?? null,
            'contributions' => $this->contributions,
            'contribution' => $this->contributions->where('current', true)->first() ?? null,
            'next_of_kin' => isset($this->kin) ? $this->kin->only('name', 'relationship', 'mobile') : null,
            'wallet' => isset($this->wallet) ? $this->wallet : null,
            'changedPassword' => $this->passwordChange == 1 ? true : false,
            'roles' => RoleResource::collection($this->roles),
            'roleLabels' => $this->roles->pluck('label')->toArray(),
            'accounts' => $this->accounts,
            'status' => $this->status,
            'installments' => InstructionResource::collection($this->installments),
            'activeLoans' => $this->loans->where('active', 1)->count(),
            'administrator' => $this->isAdministrator == 1,
            'total_outstanding' => $outstanding->sum('amount'),
        ];
    }
}
