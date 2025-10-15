<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index($slug)
    {
        $tours = Tour::whereHas('travel', function ($q) use ($slug){
            $q->where('slug', '=', $slug);
        })->paginate();

        return TourResource::collection($tours);
    }
}
