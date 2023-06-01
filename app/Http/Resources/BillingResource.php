<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "amount" => $this->amount,
            "bill_frequency" => $this->frequency,
            "bill_target" => $this->bill_target,
            "invoice_day" => $this->invoice_day,
            "invoice_month" => $this->invoice_month,
            "status" => $this->status,
            "estate_id" => $this->estate_id,
            "estate" => $this->estate->name,
            "created_at" => $this->created_at,
            "created_by" => $this->created_by,
            "created_by_user" => $this->createdBy->surname
        ];
    }
}
