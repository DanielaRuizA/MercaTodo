<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'description' => 'required|string|min:3|max:150',
            'price' => 'required|integer|digits_between:3,7|gt:0',
            'quantity' => 'required|integer|digits_between:1,5|gt:0',
            'product_photo' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
