<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ConferenceResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CategoryResource;

class ReportResource extends JsonResource
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
            'topic' => $this->topic,
            'report_start' => $this->report_start,
            'report_end' => $this->report_end,
            'description' => $this->description,
            'presentation' => $this->presentation,
            'conference_id' => new ConferenceResource($this->conference),
            'user_id' => new UserResource($this->user),
            'category_id' => new CategoryResource($this->category)
        ];
    }
}
