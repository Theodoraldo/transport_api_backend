<?php

use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\CarController;
use App\Http\Controllers\Api\V1\DriverController;
use App\Http\Controllers\Api\V1\MobileUserController;
use App\Http\Controllers\Api\V1\TripInfoController;
use App\Http\Controllers\Api\V1\WebUserController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() 
{
    Route::apiResource('car', CarController::class);
    Route::apiResource('driver', DriverController::class);
    Route::apiResource('booking', BookingController::class);
    Route::apiResource('trip', TripInfoController::class);
    Route::apiResource('webuser', WebUserController::class);
    Route::apiResource('mobileuser', MobileUserController::class);
    Route::apiResource('user', UserController::class);
    Route::put('/trips/{id}/ticketing', [TripInfoController::class, 'updateQuantity']);
});
