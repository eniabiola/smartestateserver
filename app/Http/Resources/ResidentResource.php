<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ResidentResource extends JsonResource
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
            "user_id" => $this->user->id,
            "surname" => $this->user->surname,
            "gender" => $this->user->gender,
            "othernames" => $this->user->othernames,
            "phone" => $this->user->phone,
            "status" => $this->user->isActive,
            "email" => $this->user->email,
            "imageName" => $this->user->imageName != "default.jpg" ? Storage::url('userImages/' .$this->user->imageName) : \url('/')."/default.jpg",
            "estate_id" => $this->user->estate_id,
            "estate" => $this->user->estate->name ?? null,
            "estate_code" => $this->user->estate->estateCode ?? null,
            "meterNo" => $this->meterNo,
            "houseNo" => $this->houseNo,
            "street_id" => $this->street_id,
            "street" => $this->street()->exists() ? $this->street->name : null,
        ];
    }
}
