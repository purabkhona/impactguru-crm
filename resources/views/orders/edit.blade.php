<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Order
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- ✅ Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('orders.update', $order) }}">
                    @csrf
                    @method('PUT')

                    {{-- Customer --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Customer</label>
                        <select name="customer_id" class="border rounded w-full p-2" required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Order Number --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Order Number</label>
                        <input name="order_number"
                               value="{{ old('order_number', $order->order_number) }}"
                               class="border rounded w-full p-2" required>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Amount</label>
                        <input type="number" step="0.01" name="amount"
                               value="{{ old('amount', $order->amount) }}"
                               class="border rounded w-full p-2" required>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Status</label>
                        <select name="status" class="border rounded w-full p-2" required>
                            @foreach (['pending', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $order->status) === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Order Date --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium">Order Date</label>
                        <input type="date" name="order_date"
                               value="{{ old('order_date', $order->order_date) }}"
                               class="border rounded w-full p-2" required>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('orders.index') }}" class="px-4 py-2 border rounded">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Update Order
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
