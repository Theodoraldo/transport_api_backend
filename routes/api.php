<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CarController;
use App\Http\Controllers\Api\V1\DriverController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() 
{
    Route::apiResource('car', CarController::class);
    Route::apiResource('driver', DriverController::class);
});
