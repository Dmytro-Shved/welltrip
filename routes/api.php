<?php

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\UserController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Support\Facades\Route;

// Get currently authenticated User
Route::get('/user', UserController::class)->middleware('auth:sanctum');

// Authentication routes
Route::middleware(['web'])->group(function () {
    Route::post('login', LoginController::class);
    Route::post('register', RegisterController::class);
    Route::post('logout', LogoutController::class);
});

// List of public paginated Travels
Route::get('travels', [TravelController::class, 'index']);
Route::get('travels/{travel}', [TravelController::class, 'show']);

// Admin routes
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Create new Travel
    Route::post('travels', [Admin\TravelController::class, 'store']);
    // Create new Tour by Travel
    Route::post('travels/{travel}/tours', [Admin\TourController::class, 'store']);
});

// Editor routes
Route::prefix('editor')->middleware(['auth:sanctum', 'role:editor'])->group(function () {
    // Update Travel
    Route::put('travels/{travel}', [Admin\TravelController::class, 'update']);
});

// List of paginated Tours by the Travel slug (filter enabled)
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);
