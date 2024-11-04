<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $travel_id
 * @property string $name
 * @property mixed $price
 * @property string $description
 * @property Carbon $starting_date
 * @property Carbon $ending_date
 *
 */
class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'travel_id',
        'name',
        'description',
        'starting_date',
        'ending_date',
        'price',
    ];
    protected $perPage = 15;

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100
        );
    }


}