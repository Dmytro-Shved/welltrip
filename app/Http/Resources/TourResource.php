<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'starting_date' => $this->starting_date,
            'ending_date' => $this->ending_date,
            'price' => $this->price,
        ];
    }
}
