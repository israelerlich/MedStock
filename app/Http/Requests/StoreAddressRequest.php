<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'referring_type' => 'nullable|string|max:255',
            'referring_id' => 'nullable|integer',
            'cep' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'district' => 'required|string|max:255',
            'country' => 'required|string|max:50',
            'street' => 'required|string|max:255',
            'complement_number' => 'nullable|string|max:255',
            'address_number' => 'required|string|max:20'
        ];
    }
}
