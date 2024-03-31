<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\CarController;
use App\Http\Controllers\Api\V1\DriverController;
use App\Http\Controllers\Api\V1\MobileUserController;
use App\Http\Controllers\Api\V1\WebUserController;
use App\Http\Controllers\Api\V1\TripInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Web User
Route::post('/register', [WebUserController::class, 'register']);
Route::post('/login', [WebUserController::class, 'login']);
Route::post('/logout', [WebUserController::class, 'logout']);

// Mobile User
Route::post('/signup', [MobileUserController::class, 'signup']);
Route::post('/signin', [MobileUserController::class, 'signin']);
Route::post('/signout', [MobileUserController::class, 'signout']);

Route::prefix('api/v1')->group(function () {
    Route::apiResource('car', CarController::class);
    Route::apiResource('driver', DriverController::class);
    Route::apiResource('booking', BookingController::class);
    Route::apiResource('trip', TripInfoController::class);
    Route::apiResource('users', UserController::class, ['only' => ['index', 'show']]);
    Route::put('/trips/{id}/ticketing', [TripInfoController::class, 'updateQuantity']);
})->middleware('auth:sanctum');
