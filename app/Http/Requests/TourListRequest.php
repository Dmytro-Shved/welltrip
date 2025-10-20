<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourListRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

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
            'sortOrder' => "The 'sortOrder' parameter accepts only 'asc' and 'desc' values",
        ];
    }
}
