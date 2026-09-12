<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaEventoController;
use App\Http\Controllers\EventoController;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('categorias-eventos', CategoriaEventoController::class)
    ->parameters([
        'categorias-eventos' => 'categoriaEvento',
    ]);

Route::resource('eventos', EventoController::class);