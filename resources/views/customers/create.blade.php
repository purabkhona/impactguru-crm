<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Customer
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Name</label>
                        <input name="name" value="{{ old('name') }}" class="border rounded w-full p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="border rounded w-full p-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Phone</label>
                        <input name="phone" value="{{ old('phone') }}" class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Address</label>
                        <textarea name="address" class="border rounded w-full p-2">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium">Profile Image</label>
                        <input type="file" name="profile_image" class="border rounded w-full p-2">
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('customers.index') }}" class="px-4 py-2 border rounded">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
