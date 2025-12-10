<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server error - ImpactGuru CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-xl p-8 max-w-lg text-center">
        <h1 class="text-4xl font-bold text-red-600 mb-4">500</h1>
        <h2 class="text-xl font-semibold mb-2">Something went wrong.</h2>
        <p class="text-gray-600 mb-4">
            An unexpected error occurred on the server. Our team has been notified.
        </p>
        <p class="text-xs text-gray-400 mb-6">
            (In development, details are logged in <code>storage/logs/laravel.log</code>.)
        </p>

        <a href="{{ url('/dashboard') }}"
           class="inline-block px-5 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
            Back to Dashboard
        </a>
    </div>
</body>
</html>
