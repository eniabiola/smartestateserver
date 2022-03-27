<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationGroupResource extends JsonResource
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
            "surname" => $this->surname,
            "othernames" => $this->othernames,
            "phone" => $this->phone,
            "email" => $this->email,
            "is_active" => $this->isActive,
            "estate_id" => $this->estate_id,
            "estate" => $this->estate()->exists() ? $this->estate->name : null,
        ];
    }
}
