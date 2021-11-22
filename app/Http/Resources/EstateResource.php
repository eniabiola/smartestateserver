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
            "city_id" => $this->city_id,
            "city" => $this->city->name,
            "state_id" => $this->state_id,
            "state" => $this->state->name,
            "bank_id" => $this->bank_id,
            "bank" => $this->bank->name,
            "estateCode" => $this->estateCode,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "contactPerson" => $this->contactPerson,
            "accountNumber" => $this->accountNumber,
            "accountName" => $this->accountName,
            "imageName" => $this->imageName != "default.jpg" ? url('storage/estateimages/'.$this->imageName) : "default.jpg",
            "accountVerified" => $this->accountVerified,
            "alternativeContact" => $this->alternativeContact,
            "alternateEmail" => $this->alternateEmail,
            "alternatePhone" => $this->alternatePhone,
            "status" => $this->status,
            "is_active" => $this->isActive,
            "created_by" => $this->created_by,
            "created_by_user" => $this->createdBy->surname." ".$this->createdBy->othernames
        ];
    }
}
