<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            "estate_id" => $this->estate_id,
            "estate" => $this->estate->name,
            "billing_id" => $this->billing_id,
            "user_id" => $this->user_id,
            "user" => $this->user->surname,
            "name" => $this->name,
            "description" => $this->description,
            "invoice_number" => $this->invoiceNo,
            "amount" => $this->amount,
            "status" => $this->status,
            "created_at" => $this->created_at
        ];
        return parent::toArray($request);
    }
}
