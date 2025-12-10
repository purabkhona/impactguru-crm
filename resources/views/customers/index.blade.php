<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers
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
                <form method="GET" action="{{ route('customers.index') }}" class="flex gap-2">
                    <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Search by name, email, phone"
                    class="border rounded p-2 w-64"
                    >
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">
                        Search
                    </button>
                    
                    @if(!empty($search))
                    <a href="{{ route('customers.index') }}" class="px-4 py-2 border rounded">
                        Clear
                    </a>
                    @endif
                </form>
                
                <div class="flex gap-2">
                    <a href="{{ route('customers.export.csv') }}"
                    class="px-4 py-2 border rounded">
                    Export CSV
                </a>

                <a href="{{ route('customers.export.pdf') }}"
                    class="px-4 py-2 border rounded">
                    Export PDF
                </a>
                
                <a href="{{ route('customers.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded">
                + Add Customer
            </a>
        </div>
    </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Phone</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $customer->name }}</td>
                                <td class="px-4 py-2">{{ $customer->email }}</td>
                                <td class="px-4 py-2">{{ $customer->phone }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('customers.show', $customer) }}" class="text-blue-600">View</a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600">Edit</a>

                                    @if(auth()->user()->isAdmin())
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                          onsubmit="return confirm('Delete this customer?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" type="submit">Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No customers yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
