<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BundleResource extends JsonResource
{
    protected $payment_type;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $batchCode = substr($this->batch_no, 0, 3);

        switch ($batchCode) {
            case "MMP":
                $this->payment_type = "Member Payment";
                break;
            case "STP":
                $this->payment_type = "Staff Payment";
                break;
            default:
                $this->payment_type = "Third Party Payment";
                break;
        }
        
        return [
            'id' => $this->id,
            'batch_no' => $this->batch_no,
            'noOfClaim' => $this->noOfClaim,
            'amount' => $this->amount,
            'expenditures' => DisbursementResource::collection($this->expenditures),
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
