<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ✅ STAT BOXES --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-sm text-gray-500">Total Customers</h3>
                    <p class="text-2xl font-bold">{{ $totalCustomers }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-sm text-gray-500">Total Orders</h3>
                    <p class="text-2xl font-bold">{{ $totalOrders }}</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="text-sm text-gray-500">Total Revenue</h3>
                    <p class="text-2xl font-bold">₹ {{ number_format($totalRevenue, 2) }}</p>
                </div>

            </div>

            {{-- ✅ RECENT CUSTOMERS --}}
            <div class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Customers</h3>

                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-3 py-2">Name</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomers as $customer)
                            <tr class="border-b">
                                <td class="px-3 py-2">{{ $customer->name }}</td>
                                <td class="px-3 py-2">{{ $customer->email }}</td>
                                <td class="px-3 py-2">{{ $customer->phone }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-4 text-center text-gray-500">
                                    No customers yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>
