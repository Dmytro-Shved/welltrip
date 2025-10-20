<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourListRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'priceFrom' => ['nullable', 'numeric', 'min:0'],
            'priceTo' => ['nullable', 'numeric', 'min:0'],
            'dateFrom' => ['nullable', 'date', 'date_format:Y-m-d'],
            'dateTo' => ['nullable', 'date', 'date_format:Y-m-d'],
            'priceOrder' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }
}
