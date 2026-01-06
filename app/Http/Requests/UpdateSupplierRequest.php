<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier')->id;
        return [
            'company_name' => 'required|string|max:255',
            'commercial_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'cnpj' => 'required|string|max:18|unique:suppliers,cnpj,' . $supplierId,
            'email' => 'required|email|max:255|unique:suppliers,email,' . $supplierId
        ];
    }
}
