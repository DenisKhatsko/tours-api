<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Public endpoints
 */
class TravelController
{
    /**
     * GET Travels
     *
     * returns paginated list of travels
     *
     * @response {"data": [{"id": "9d629399-b9b3-4a97-be48-f6787128be36", "name": "Quis neque eaque.","slug": "quis-neque-eaque", "number_of_days": 8,"number_of_nights": 7, "description": "Magni dolor vero veniam. Adipisci non fuga qui excepturi beatae." }]}
     */
    public function index(): JsonResource
    {
        $travels = Travel::query()
            ->where('is_public', '=', true)
            ->paginate();

        return TravelResource::collection($travels);
    }
}
