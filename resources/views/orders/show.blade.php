<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Order Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="space-y-2 text-sm">
                    <p><strong>Order #:</strong> {{ $order->order_number }}</p>
                    <p><strong>Customer:</strong> {{ $order->customer?->name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer?->email }}</p>
                    <p><strong>Amount:</strong> ₹ {{ number_format($order->amount, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Date:</strong> {{ $order->order_date }}</p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('orders.index') }}" class="text-indigo-600">
                        ← Back to orders
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
