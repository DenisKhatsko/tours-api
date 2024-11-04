<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\ToursListRequest;
use App\Http\Resources\V1\TourResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;


class TourController
{
    public function index(Travel $travel, ToursListRequest $request): JsonResource
    {
        $tours = $travel->tours()
            ->when($request->priceFrom, function($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function($query) use ($request) {
                $query->where('price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function($query) use ($request) {
                $query->where('ending_date', '<=', $request->dateTo);
            })
            ->when($request->sortBy && $request->sortOrder, function($query) use ($request) {
                $query->orderBy($request->sortBy, $request->sortOrder);
            })
            ->orderBy('starting_date')
            ->paginate();

        return TourResource::collection($tours);
    }
}