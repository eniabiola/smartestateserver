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
            "visitor_pass_category_id" => $this->visitor_pass_category_id,
            "visitor_pass_category" => $this->visitorPassCategory->name,
            "guestName" => $this->guestName,
            "gender" => $this->gender,
            "visitationDate" => date('Y-m-d', strtotime($this->visitationDate)),
            "dateExpires" => date('Y-m-d', strtotime($this->dateExpires)),
            "estate" => $this->estate->name,
            "user" => $this->user->surname,
            "isRecurrent" => $this->isRecurrent
        ];
    }
}
