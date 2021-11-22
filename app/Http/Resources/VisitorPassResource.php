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
            "id" => $this->id,
            "guestName" => $this->guestName,
            "pass_code" => $this->generatedCode,
            "visitationDate" => date('Y-m-d H:i:s', strtotime($this->visitationDate)),
            "duration" => $this->duration,
            "dateExpires" => date('Y-m-d H:i:s', strtotime($this->dateExpires)),
            "estate_id" => $this->estate_id,
            "estate" => $this->estate->name,
            "user" => $this->user->surname,
            "status" => $this->status,
            "checked_in_time" => $this->checked_in_time,
            "checked_out_time" => $this->checked_out_time
            ];
    }
}
