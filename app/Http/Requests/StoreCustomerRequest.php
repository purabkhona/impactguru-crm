<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    // ✅ Anyone logged in can create customer
    public function authorize(): bool
    {
        return true;
    }

    // ✅ All validation rules here
    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }

    // ✅ Custom error messages (optional but professional)
    public function messages(): array
    {
        return [
            'name.required'  => 'Customer name is required',
            'email.required' => 'Email is required',
            'email.unique'   => 'This email already exists',
        ];
    }
}
