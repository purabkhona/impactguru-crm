<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;

class CustomerApiController extends Controller
{
    // GET /api/customers
    public function index(Request $request)
    {
        $customers = Customer::orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $customers,
        ]);
    }

    // GET /api/customers/{id}
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer,
        ]);
    }

    public function store(StoreCustomerRequest $request)
{
    $customer = Customer::create($request->validated());

    return response()->json([
        'message' => 'Customer created successfully',
        'data'    => $customer,
    ], 201);
}

    // PUT /api/customers/{id}  (ADMIN only)
    public function update(Request $request, Customer $customer)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden: only admin can update customers',
            ], 403);
        }

        $validated = $request->validate([
            'name'    => 'sometimes|required|string|max:255',
            'email'   => 'sometimes|required|email|unique:customers,email,' . $customer->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Customer updated successfully',
            'data'    => $customer,
        ]);
    }

    // DELETE /api/customers/{id}  (ADMIN only)
    public function destroy(Request $request, Customer $customer)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden: only admin can delete customers',
            ], 403);
        }

        $customer->delete();

        return response()->json([
            'message' => 'Customer deleted successfully',
        ]);
    }
}
