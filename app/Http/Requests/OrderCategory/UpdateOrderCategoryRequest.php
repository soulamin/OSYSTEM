<?php

namespace App\Http\Requests\OrderCategory;

use App\Models\OrderCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var OrderCategory $category */
        $category = $this->route('order_category');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:150', Rule::unique('order_categories', 'name')->ignore($category?->id)],
        ];
    }
}
