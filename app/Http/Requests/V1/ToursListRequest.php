<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property int $priceFrom
 * @property int $priceTo
 * @property string $dateFrom
 * @property string $dateTo
 * @property string $sortBy
 * @property string $sortOrder
 */
class ToursListRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'date',
            'dateTo' => 'date',
            'sortBy' => Rule::in(['price']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return [
            'sortBy' => "The 'sortBy' parameter accepts only 'price' value",
            'sortOrder' => "The 'orderBy' parameter accepts only 'asc' or 'desc' value",
        ];
    }
}
