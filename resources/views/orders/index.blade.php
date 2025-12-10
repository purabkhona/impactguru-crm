<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orders
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

    <form method="GET" action="{{ route('orders.index') }}" class="flex flex-wrap gap-2">

        <select name="status" class="border rounded p-2">
            <option value="">All Statuses</option>
            @foreach (['pending', 'completed', 'cancelled'] as $s)
                <option value="{{ $s }}" {{ ($status ?? '') === $s ? 'selected' : '' }}>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>

        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Search by order # or customer"
            class="border rounded p-2 w-64"
        >

        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">
            Filter
        </button>

        @if(!empty($status) || !empty($search))
            <a href="{{ route('orders.index') }}" class="px-4 py-2 border rounded">
                Clear
            </a>
        @endif
    </form>

    <div class="flex gap-2">
        <a href="{{ route('orders.export.csv') }}"
           class="px-4 py-2 border rounded">
            Export CSV
        </a>

        <a href="{{ route('orders.export.pdf') }}"
            class="px-4 py-2 border rounded">
            Export PDF
        </a>

        <a href="{{ route('orders.create') }}"
           class="px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Order
        </a>
    </div>
</div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Order #</th>
                            <th class="px-4 py-2">Customer</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $order->order_number }}</td>
                                <td class="px-4 py-2">{{ $order->customer?->name }}</td>
                                <td class="px-4 py-2">{{ number_format($order->amount, 2) }}</td>
                                <td class="px-4 py-2 capitalize">{{ $order->status }}</td>
                                <td class="px-4 py-2">{{ $order->order_date }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600">View</a>
                                    <a href="{{ route('orders.edit', $order) }}" class="text-yellow-600">Edit</a>

                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                              onsubmit="return confirm('Delete this order?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600" type="submit">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    No orders yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
