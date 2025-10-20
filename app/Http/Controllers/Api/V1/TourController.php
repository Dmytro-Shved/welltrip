<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourListRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

class TourController extends Controller
{
    public function index(Travel $travel, TourListRequest $request)
    {
       $validated = $request->validated();

        $priceFrom = $validated['priceFrom'] ?? null;
        $priceTo = $validated['priceTo'] ?? null;
        $dateFrom = $validated['dateFrom'] ?? null;
        $dateTo = $validated['dateTo'] ?? null;
        $priceOrder = $validated['priceOrder'] ?? null;

        $tours = $travel->tours()
            ->when($priceFrom, function ($query) use ($priceFrom){
               $query->where('price', '>=', $priceFrom * 100);
            })
            ->when($priceTo, function ($query) use ($priceTo){
                $query->where('price', '<=', $priceTo * 100);
            })
            ->when($dateFrom, function ($query) use ($dateFrom){
                $query->where('starting_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo){
                $query->where('ending_date', '<=', $dateTo);
            })
            ->when($priceOrder, function ($query) use ($priceOrder) {
                    $query->orderBy('price', $priceOrder);
                })
            ->orderBy('starting_date')
            ->paginate();

        return TourResource::collection($tours);
    }
}
