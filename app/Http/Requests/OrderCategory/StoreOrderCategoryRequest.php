<?php

namespace App\Http\Requests\OrderCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'unique:order_categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}

