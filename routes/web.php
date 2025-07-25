<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Restaurant;

Route::get('/debug-restaurants', function() {
    return Restaurant::all()->pluck('name');
});