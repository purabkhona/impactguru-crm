<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Models\Customer;
use App\Models\Order;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {

    $totalCustomers = Customer::count();
    $totalOrders = Order::count();
    $totalRevenue = Order::sum('amount');
    $recentCustomers = Customer::latest()->take(5)->get();

    return view('dashboard', compact(
        'totalCustomers',
        'totalOrders',
        'totalRevenue',
        'recentCustomers'
    ));

})->middleware(['auth'])->name('dashboard');

    // Customers
    Route::resource('customers', CustomerController::class)->except('destroy');
    Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])
        ->name('customers.destroy')
        ->middleware('admin');
    Route::get('customers/export/csv', [CustomerController::class, 'exportCsv'])
        ->name('customers.export.csv');
    Route::get('customers/export/pdf', [CustomerController::class, 'exportPdf'])
        ->name('customers.export.pdf');


    // Orders: staff + admin can list/add/edit/view
    Route::resource('orders', OrderController::class)->except('destroy');
    // Delete order: admin only
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy')
        ->middleware('admin');
    Route::get('orders/export/csv', [OrderController::class, 'exportCsv'])
        ->name('orders.export.csv');
    Route::get('orders/export/pdf', [OrderController::class, 'exportPdf'])
        ->name('orders.export.pdf');


    Route::get('/admin-test', function () {
        return 'Only admin can see this';
    })->middleware('admin');
});

Route::get('/error-test', function () {
    abort(500);
});

require __DIR__.'/auth.php';
