<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('categories', CategoryController::class)->except(['show']);
Route::resource('venues', VenueController::class)->except(['show']);
