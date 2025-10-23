<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function store(Travel $travel, TourRequest $request)
    {
        $tour = Tour::create([
            'travel_id' => $travel->id,
            'name' => $request->name,
            'starting_date' => $request->starting_date,
            'ending_date' => $request->ending_date,
            'price' => $request->price,
        ]);

        return new TourResource($tour);
    }
}
