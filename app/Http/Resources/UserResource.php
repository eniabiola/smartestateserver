<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "gender" => $this->gender,
            "email" => $this->email,
            "is_active" => $this->isActive,
            "role" => $this->roles()->exists() ? $this->roles[0]->name : null,
            $this->mergeWhen($this->roles()->exists() && $this->roles[0]->name == "resident",
                ['resident' => [ $this->resident ]])
        ];
    }
}
