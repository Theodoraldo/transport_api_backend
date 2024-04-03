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
    return $request->user()->id;
})->middleware('auth:sanctum');

// Web User
Route::controller(WebUserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
});

// Mobile User
Route::controller(MobileUserController::class)->group(function () {
    Route::post('/signup', 'signup');
    Route::post('/signin', 'signin');
    Route::get('/signout', 'signout');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['auth:sanctum']], function () {
    Route::apiResource('users', UserController::class, ['only' => ['index', 'show']]);
    Route::put('/users/{id}', [MobileUserController::class, 'update']);
    Route::put('/trips/{id}/ticketing', [TripInfoController::class, 'updateQuantity']);
    Route::apiResource('driver', DriverController::class);
    Route::apiResource('car', CarController::class);
    Route::apiResource('booking', BookingController::class);
    Route::apiResource('trip', TripInfoController::class);
});
