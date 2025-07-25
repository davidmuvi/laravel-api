<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Laravel\Passport\Http\Middleware\CheckTokenForAnyScope;

// Define the API Routes for authentication.
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Define the API routes that all users can use.
Route::middleware(['auth:api', CheckTokenForAnyScope::using('user:read')])->group(function () {
    // Endpoint to get the restaurant's information.
    Route::get('/restaurants', [RestaurantController::class, 'index']);

    // Endpoint to get the restaurant's information by ID.
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

    // Endpoint to get the restaurant's information by name.
    Route::get('/restaurants/name/{name}', [RestaurantController::class, 'showByName']);
});

// Define the API routes that only admin users can use.
Route::middleware(['auth:api', CheckTokenForAnyScope::using('user:all')])->group(function () {
    // Endpoint to create a new restaurant.
    Route::post('/restaurants', [RestaurantController::class, 'store']);

    // Endpoint to update a restaurant by ID.
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update']);

    // Endpoint to delete a restaurant by ID.
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy']);
});