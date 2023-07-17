<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class OrderReportRequest extends FormRequest
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
            'date_1' => 'nullable|date',
            'date_2' => 'nullable|date',
            'orderStatus' => 'nullable|string',
            'minAmount' => 'nullable|integer',
            'maxAmount' => 'nullable|integer',
            'time' => 'required|string',
        ];
    }
}
