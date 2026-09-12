<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaEventoController;
use App\Http\Controllers\EventoController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('categorias-eventos', CategoriaEventoController::class)
    ->parameters([
        'categorias-eventos' => 'categoriaEvento',
    ]);

Route::resource('eventos', EventoController::class);

Route::get('/entrar-teste', function () {
    $usuario = User::first();

    Auth::login($usuario);

    return redirect()->route('eventos.create');
});