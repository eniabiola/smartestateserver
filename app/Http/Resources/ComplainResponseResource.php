<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplainResponseResource extends JsonResource
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
            "response" => $this->response,
            "complain_id" => $this->complain_id,
            "isOwner" =>  $this->isOwner,
            "user" => $this->user->surname." ".$this->user->othernames,
            "estate_id" => $this->estate_id,
            "estate" => $this->estate->user,
            "user_role" => $this->user_role,
        ];
        return parent::toArray($request);
    }
}
