<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreCustomerRequest;

class CustomerController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');

    $query = Customer::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    $customers = $query->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString(); // keeps search in pagination links

    return view('customers.index', compact('customers', 'search'));
}


    public function create()
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request)
{
    Customer::create($request->validated());

    return redirect()->route('customers.index')
        ->with('success', 'Customer created successfully!');
}


    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:customers,email,' . $customer->id,
            'phone'  => 'nullable|string|max:20',
            'address'=> 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            // delete old image if exists
            if ($customer->profile_image) {
                Storage::disk('public')->delete($customer->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('customers', 'public');
        }

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        // soft delete
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function exportCsv()
    {
    $fileName = 'customers_' . now()->format('Ymd_His') . '.csv';

    $callback = function () {
        $handle = fopen('php://output', 'w');

        // Header row
        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Address', 'Created At']);

        // Data rows
        Customer::orderBy('id')->chunk(200, function ($customers) use ($handle) {
            foreach ($customers as $customer) {
                fputcsv($handle, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone,
                    $customer->address,
                    $customer->created_at,
                ]);
            }
        });

        fclose($handle);
    };

    return response()->streamDownload($callback, $fileName, [
        'Content-Type' => 'text/csv',
    ]);
    }

    public function exportPdf()
{
    $customers = Customer::orderBy('name')->get();

    $pdf = Pdf::loadView('exports.customers', compact('customers'));

    $fileName = 'customers_' . now()->format('Ymd_His') . '.pdf';

    return $pdf->download($fileName);
}

}
