<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplainCategoryWithComplainResource extends JsonResource
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
          'id' => $this->id,
          'name' => $this->name,
          'estate_id' => $this->estate_id,
          'estate' => $this->estate->name,
            $this->mergeWhen($this->complains()->exists(),
                ['complain_responses' => $this->complains])
        ];
        return parent::toArray($request);
    }
}
