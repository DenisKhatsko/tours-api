<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\V1\TourRequest;
use App\Http\Resources\V1\TourResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

class TourController
{
    public function store(Travel $travel, TourRequest $request): JsonResource
    {
        $tour = $travel->tours()->create($request->validated());

        return new TourResource($tour);
    }
}
