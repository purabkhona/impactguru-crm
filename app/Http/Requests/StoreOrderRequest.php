<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    // ✅ Anyone logged in can create an order
    public function authorize(): bool
    {
        return true;
    }

    // ✅ All validation rules for ORDERS
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'product_name'=> 'required|string|max:255',
            'quantity'    => 'required|integer|min:1',
            'amount'      => 'required|numeric|min:1',
            'status'      => 'required|string|max:100',
        ];
    }

    // ✅ Custom validation messages (optional but good)
    public function messages(): array
    {
        return [
            'customer_id.required' => 'Customer is required',
            'customer_id.exists'   => 'Selected customer does not exist',
            'product_name.required'=> 'Product name is required',
            'quantity.required'   => 'Quantity is required',
            'amount.required'     => 'Amount is required',
            'status.required'     => 'Order status is required',
        ];
    }
}
