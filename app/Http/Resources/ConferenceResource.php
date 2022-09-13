<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\UserResource;

class ConferenceResource extends JsonResource
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
            'title' => $this->title,
            'conference_date' => $this->conference_date,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'country_id' => new CountryResource($this->country),
            'user_id' => new UserResource($this->user),
            'category_id' => new CategoryResource($this->category),
            'subcategory_id' => new SubcategoryResource($this->subcategory),
            'reports' => $this->reports
        ];
    }
}
