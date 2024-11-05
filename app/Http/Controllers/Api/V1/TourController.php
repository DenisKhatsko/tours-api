<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ToursListRequest;
use App\Http\Resources\V1\TourResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Public endpoints
 */
class TourController
{
    /**
     * GET Travel Tours
     *
     * Returns paginated list of tours by travel slug
     *
     * @urlParam travel_slug string Travel slug. Example: "first-travel"
     *
     * @bodyParam priceFrom number. Example: "123.45"
     * @bodyParam priceTo number. Example: "123.45"
     * @bodyParam dateFrom date. Example: "2024-11-01 09:00:00"
     * @bodyParam dateTo date. Example: "2024-11-01 09:00:00"
     * @bodyParam sortBy string. Example: "price"
     * @bodyParam sortOrder string. Example: "asc" or "desc"
     *
     * @response {"data":[{"id": "9d62939a-6b0c-4529-a6d8-6717958c5ce4","name": "Odio occaecati.","starting_date": "2025-06-01","ending_date": "2025-06-10", "price": "51.18"}]}
     */
    public function index(Travel $travel, ToursListRequest $request): JsonResource
    {
        $tours = $travel->tours()
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('ending_date', '<=', $request->dateTo);
            })
            ->when($request->sortBy && $request->sortOrder, function ($query) use ($request) {
                $query->orderBy($request->sortBy, $request->sortOrder);
            })
            ->orderBy('starting_date')
            ->paginate();

        return TourResource::collection($tours);
    }
}
