<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelResource extends JsonResource
{
    /**
     * Transform the resource into an array
     */
    public function toArray(Request $request): array
    {
        return [
            'is_public' => $this->is_public,
            'slug' => $this->slug,
            'name' => $this->name,
            'description' => str($this->description)->limit(30),
            'number_of_days' => $this->number_of_days,
            'number_of_nights' => $this->number_of_nights
        ];
    }
}
