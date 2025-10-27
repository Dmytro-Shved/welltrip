<?php

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;

Route::get('travels', [TravelController::class, 'index']);

Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('travels', [Admin\TravelController::class, 'store']);
    Route::post('travels/{travel}/tours', [Admin\TourController::class, 'store']);
});

Route::prefix('editor')->middleware(['auth:sanctum', 'role:editor'])->group(function () {
    Route::put('travels/{travel}', [Admin\TravelController::class, 'update']);
});

Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);

Route::post('login', LoginController::class);
