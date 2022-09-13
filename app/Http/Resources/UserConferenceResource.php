<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ConferenceResource;
use App\Http\Resources\UserResource;


class UserConferenceResource extends JsonResource
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
            // 'conference_id' => new ConferenceResource($this->conference),
            // 'user_id' => new UserResource($this->user),
            'conference_id' => $this->conference_id,
            'user_id' => $this->user_id
        ];
    }
}
