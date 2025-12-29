<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

/**
 * @group Public endpoints
 */
class TravelController extends Controller
{
    /**
     * GET Travels
     *
     * Returns paginated list of travels.
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":[{"id":"9958e389-5edf-48eb-8ecd-e058985cf3ce","name":"First travel", ...}}
     */
    public function index()
    {
        $travels = Travel::where('is_public', true)->paginate();

        return TravelResource::collection($travels);
    }

    /**
     * Returns a single Travel resource by its identifier.
     *
     * Returns a single travel resource by its identifier.
     *
     * @urlParam travel uuid required The ID of the travel. Example: 9958e389-5edf-48eb-8ecd-e058985cf3ce
     *
     * @response 200 {"data":[{"id":"9958e389-5edf-48eb-8ecd-e058985cf3ce", "name":"First travel", ...}}
     */
    public function show(Travel $travel)
    {
        return TravelResource::make($travel);
    }
}
