<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|integer|in:1,2,3',
            'status' => 'required|integer|in:1,2,3',
            'expires_at' => 'nullable|date'
        ];
    }
}
