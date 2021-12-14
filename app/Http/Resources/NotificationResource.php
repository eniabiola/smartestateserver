<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'message' => $this->message,
            'file' => $this->file,
            'file_path' => $this->file != null ? Storage::url('notificationImages/' .$this->file) : null,
            'recipient_type' => $this->recipient_type,
            'created_by' => $this->created_by,
            'created_by_user' => $this->createdBy->surname." ".$this->createdBy->othernames,
            'estate_id' => $this->estate_id,
            'estate' => $this->estate->name,
            $this->mergeWhen($this->receiver_id != null,
                ['receiver_id' => $this->receiver_id]),
            $this->mergeWhen($this->receiver()->exists(),
                ['receiver' => $this->receiver]),
            $this->mergeWhen($this->group_id != null,
                ['group_id' => $this->group_id]),
            $this->mergeWhen($this->group()->exists(),
                ['group' => $this->group]),
            $this->mergeWhen($this->street_id != null,
                ['street_id' => $this->street_id]),
            $this->mergeWhen($this->street()->exists(),
                ['street' => $this->street]),
            "created_at" => date("Y-m-d h:i:s a", strtotime($this->created_at))
        ];
    }
}
