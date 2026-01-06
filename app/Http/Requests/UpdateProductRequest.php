<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'hospital_id' => 'nullable|exists:hospitals,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|integer|in:1,2,3',
            'status' => 'required|integer|in:1,2,3',
            'current_stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'expires_at' => 'nullable|date|after:1900-01-01|before:2100-12-31'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'expires_at.date' => 'A data de validade deve ser uma data válida.',
            'expires_at.after' => 'A data de validade deve ser posterior a 01/01/1900.',
            'expires_at.before' => 'A data de validade deve ser anterior a 31/12/2100.',
        ];
    }
}
