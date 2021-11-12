<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstateResource extends JsonResource
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
            "city" => $this->city->name,
            "state" => $this->state->name,
            "country" => $this->country->name,
            "bank" => $this->bank->name,
            "estateCode" => $this->estateCode,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "accountNumber" => $this->accountNumber,
            "accountName" => $this->accountName,
            "imageName" => $this->imageName,
            "accountVerified" => $this->accountVerified,
            "alternativeContact" => $this->alternativeContact,
            "alternateEmail" => $this->alternateEmail,
            "alternatePhone" => $this->alternatePhone,
            "status" => $this->status,
            "created_by" => $this->created_by
        ];
    }
}
