<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelController extends Controller
{
    public function index(): JsonResource
    {
        $travels = Travel::query()
            ->where('is_public', '=', true)
            ->paginate();

        return TravelResource::collection($travels);
    }
}
