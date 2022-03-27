<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ComplainAPIResource extends JsonResource
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
            'complain_category_id' => $this->complain_category_id,
            'complain_category' => $this->complainCategory()->exists() ? $this->complainCategory->name : null,
            "user_id" => $this->user_id,
            "user" => $this->user()->exists() ? $this->user->surname." ".$this->user->othernames : null,
            "estate_id" => $this->estate_id,
            "estate" => $this->estate()->exists() ? $this->estate->name : null,
            "ticket_no" => $this->ticket_no,
            "subject" => $this->subject,
            "priority" => $this->priority,
            "file_url" => $this->file != null ? Storage::url('complainImages/' .$this->file) : null,
            "file" => $this->file,
            "description" => $this->description,
            "status" => $this->status,
            "date_created" => $this->created_at != null ? date('d/m/y H:i:s', strtotime($this->created_at)) : null,
            $this->mergeWhen($this->complainResponses()->exists(),
                ['complain_responses' => $this->complainResponses])
        ];
    }
}
