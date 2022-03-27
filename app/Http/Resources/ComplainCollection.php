<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ComplainCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($complain) {
            return [
                "id" => $complain->id,
                'complain_category_id' => $complain->complain_category_id,
                'complain_category' => $complain->complainCategory()->exists() ? $complain->complainCategory->name : null,
                "user_id" => $complain->user_id,
                "user" => $complain->user()->exists() ? $complain->user->surname . " " . $complain->user->othernames : null,
                "estate_id" => $complain->estate_id,
                "estate" => $complain->estate()->exists() ? $complain->estate->name : null,
                "ticket_no" => $complain->ticket_no,
                "subject" => $complain->subject,
                "priority" => $complain->priority,
                "file" => $complain->file ?? null,
                "description" => $complain->description,
                "status" => $complain->status,
                $this->mergeWhen($complain->complainResponses()->exists(),
                    ['complain_responses' => $complain->complainResponses])
            ];
        });
    }
}
