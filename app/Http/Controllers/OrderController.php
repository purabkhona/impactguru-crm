<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\StoreOrderRequest;


class OrderController extends Controller
{
    public function index(Request $request)
{
    $status = $request->query('status');
    $search = $request->query('search');

    $query = Order::with('customer');

    if ($status) {
        $query->where('status', $status);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhereHas('customer', function ($customerQuery) use ($search) {
                  $customerQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    $orders = $query
        ->orderBy('order_date', 'desc')
        ->paginate(10)
        ->withQueryString();

    return view('orders.index', compact('orders', 'status', 'search'));
}


    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        return view('orders.create', compact('customers'));
    }

    public function store(StoreOrderRequest $request)
{
    Order::create($request->validated());

    return redirect()->route('orders.index')
        ->with('success', 'Order created successfully!');
}


    public function show(Order $order)
    {
        $order->load('customer');

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::orderBy('name')->get();

        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'order_number' => 'required|string|max:255|unique:orders,order_number,' . $order->id,
            'amount'       => 'required|numeric|min:0',
            'status'       => 'required|in:pending,completed,cancelled',
            'order_date'   => 'required|date',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function exportCsv()
{
    $fileName = 'orders_' . now()->format('Ymd_His') . '.csv';

    $callback = function () {
        $handle = fopen('php://output', 'w');

        // Header row
        fputcsv($handle, ['ID', 'Order #', 'Customer', 'Amount', 'Status', 'Order Date']);

        // Data rows
        Order::with('customer')->orderBy('order_date', 'desc')->chunk(200, function ($orders) use ($handle) {
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->order_number,
                    optional($order->customer)->name,
                    $order->amount,
                    $order->status,
                    $order->order_date,
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
    $orders = Order::with('customer')
        ->orderBy('order_date', 'desc')
        ->get();

    $pdf = Pdf::loadView('exports.orders', compact('orders'));

    $fileName = 'orders_' . now()->format('Ymd_His') . '.pdf';

    return $pdf->download($fileName);
}


}
