<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\CustomerApiController;

// ✅ REAL API LOGIN (returns TOKEN)
Route::post('login', function (Request $request) {

    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
        ],
    ]);
});

// ✅ PROTECTED CUSTOMER APIs
Route::middleware('auth:sanctum')->group(function () {

    Route::get('customers', [CustomerApiController::class, 'index']);
    Route::get('customers/{customer}', [CustomerApiController::class, 'show']);
    Route::post('customers', [CustomerApiController::class, 'store']);
    Route::put('customers/{customer}', [CustomerApiController::class, 'update']);
    Route::delete('customers/{customer}', [CustomerApiController::class, 'destroy']);

});
