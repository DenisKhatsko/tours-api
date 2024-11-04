<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelController
{
    public function index(): JsonResource
    {
        $travels = Travel::query()
            ->where('is_public', '=', true)
            ->paginate();

        return TravelResource::collection($travels);
    }
}
