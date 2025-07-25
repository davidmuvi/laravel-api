<?php

use Illuminate\Support\Facades\Route;
use App\Models\Restaurant;

Route::get('/debug-restaurants', function() {
    return Restaurant::all()->pluck('name');
});