<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "email" => $this->user->email,
            "estate" => $this->user->estate->name ?? null,
            "meterNo" => $this->meterNo,
            "houseNo" => $this->houseNo,
            "street" => $this->street,
            "dateMovedIn" => date("Y-m-d", strtotime($this->dateMovedIn))
        ];
    }
}
