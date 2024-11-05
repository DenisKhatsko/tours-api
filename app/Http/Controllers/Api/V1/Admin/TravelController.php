<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Requests\V1\TravelRequest;
use App\Http\Resources\V1\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Admin endpoints
 */
class TravelController
{
    /**
     * POST Travel
     *
     * Creates a new Travel record
     *
     * @authenticated
     *
     * @response {"data": {"id": "9d6aadc3-642c-481f-b051-28617c6e6387","name": "Newest Name","slug": "newest-name", "number_of_days": "5","number_of_nights": 4,"description": "some description"}}
     * @response 422 {"message": "The name has already been taken.","errors": {"name": ["The name has already been taken."]}}
     */
    public function store(TravelRequest $travelRequest): JsonResource
    {
        $travel = Travel::create($travelRequest->validated());

        return new TravelResource($travel);
    }

    /**
     * PUT Travel
     *
     * Updates a Travel record.
     *
     * @authenticated
     *
     * @response {"data": {"id": "9d6aadc3-642c-481f-b051-28617c6e6387","name": "Newest Name 2","slug": "newest-name", "number_of_days": "5","number_of_nights": 4,"description": "some description"}}
     * @response 422 {"message": "The name has already been taken.","errors": {"name": ["The name has already been taken."]}}
     */
    public function update(Travel $travel, TravelRequest $travelRequest): JsonResource
    {
        $travel->update($travelRequest->validated());

        return new TravelResource($travel);
    }
}
