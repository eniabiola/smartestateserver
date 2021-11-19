<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorPassResource extends JsonResource
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
            "guestName" => $this->guestName,
            "visitationDate" => date('Y-m-d H:i:s', strtotime($this->visitationDate)),
            "dateExpires" => date('Y-m-d H:i:s', strtotime($this->dateExpires)),
            "estate" => $this->estate->name,
            "user" => $this->user->surname,
            "status" => $this->status,
            ];
    }
}
