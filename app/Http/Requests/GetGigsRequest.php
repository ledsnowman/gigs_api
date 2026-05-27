<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetGigsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Разрешаем доступ всем
    }

    public function rules(): array
    {
        return [
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'], // Проверяем, что ID категорий существуют
            'date_from' => ['nullable', 'date', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:date_from'],
        ];
    }
}
