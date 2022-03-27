<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorGroupResource extends JsonResource
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
            "visitor_pass_id" => $this->visitor_pass_id,
            "event" =>  $this->event,
            "expected_number_of_guests" =>  $this->expected_number_of_guests,
            "number_of_guests_in" => $this->number_of_guests_in,
            "number_of_guests_out" => $this->number_of_guests_out,
            "isApproved" =>  $this->isApproved,
            "created_at" => date("Y-m-d H:i:s", strtotime($this->created_at)),
        ];
        return parent::toArray($request);
    }
}
