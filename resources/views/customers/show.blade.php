<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customer Details
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Profile Image --}}
                @if($customer->profile_image)
                    <div class="mb-4">
                        <img
                            src="{{ asset('storage/'.$customer->profile_image) }}"
                            alt="Profile image"
                            class="h-20 w-20 rounded-full object-cover"
                        >
                    </div>
                @endif

                {{-- Basic Details --}}
                <div class="space-y-2 text-sm">
                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                    <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                    <p><strong>Address:</strong> {{ $customer->address }}</p>
                </div>

                {{-- (Optional) List of this customer's orders --}}
                @if($customer->orders && $customer->orders->count())
                    <div class="mt-6">
                        <h3 class="font-semibold mb-2">Orders</h3>
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-3 py-2">Order #</th>
                                    <th class="px-3 py-2">Amount</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders as $order)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">{{ $order->order_number }}</td>
                                        <td class="px-3 py-2">{{ number_format($order->amount, 2) }}</td>
                                        <td class="px-3 py-2 capitalize">{{ $order->status }}</td>
                                        <td class="px-3 py-2">{{ $order->order_date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('customers.index') }}" class="text-indigo-600">
                        ← Back to customers
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
