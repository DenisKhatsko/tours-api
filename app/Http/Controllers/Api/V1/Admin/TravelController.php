<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\V1\TravelRequest;
use App\Http\Resources\V1\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelController
{
    public function store(TravelRequest $travelRequest): JsonResource
    {
        $travel = Travel::create($travelRequest->validated());

        return new TravelResource($travel);
    }

    public function update(Travel $travel, TravelRequest $travelRequest): JsonResource
    {
        $travel->update($travelRequest->validated());

        return new TravelResource($travel);
    }
}
