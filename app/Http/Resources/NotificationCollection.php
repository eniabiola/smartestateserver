<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        return $this->collection->map(function ($notification) {
            return [
                'id' => $notification->id,
                'name' => $notification->name,
                'title' => $notification->title,
                'message' => $notification->message,
                'file' => $notification->file,
                'recipient_type' => $notification->recipient_type,
                'created_by' => $notification->created_by,
                'created_by_user' => $notification->createdBy->surname . " " . $notification->createdBy->othernames,
                'estate_id' => $notification->estate_id,
                'estate' => $notification->estate->name,
                $notification->mergeWhen($notification->receiver_id != null,
                    ['receiver_id' => $notification->receiver_id]),
                $notification->mergeWhen($notification->receiver()->exists(),
                    ['receiver' => $notification->receiver]),
                $notification->mergeWhen($notification->group_id != null,
                    ['group_id' => $notification->group_id]),
                $notification->mergeWhen($notification->group()->exists(),
                    ['group' => $notification->group]),
                $notification->mergeWhen($notification->street_id != null,
                    ['street_id' => $notification->street_id]),
                $notification->mergeWhen($notification->street()->exists(),
                    ['street' => $notification->street])
            ];
        });
        return parent::toArray($request);
    }
}
