<?php

namespace App\Http\Resources\V1;

use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Travel
 */
class TravelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'number_of_days' => $this->number_of_days,
            'number_of_nights' => $this->number_of_nights,
            'description' => $this->description,

        ];
    }
}
