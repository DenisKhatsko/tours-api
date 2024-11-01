<?php

namespace App\Http\Resources\V1;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin Tour
 */
class TourResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'starting_date' => \DateTime::createFromFormat('Y-m-d H:m:i', $this->starting_date)->format('Y-m-d'),
            'ending_date' => \DateTime::createFromFormat('Y-m-d H:m:i', $this->ending_date)->format('Y-m-d'),
            'price' => number_format($this->price, 2)
        ];
    }
}
