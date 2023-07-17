<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [

            'name' => 'string|min:3|max:100',
            'description' => 'string|min:3|max:150',
            'price' => 'integer|digits_between:3,7|gt:0',
            'quantity' => 'integer|digits_between:1,5|gt:0',
            // 'product_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
