<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VenueController;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('categories', CategoryController::class)
    ->except(['show'])
    ->middleware(['auth', 'role:admin']);

Route::resource('venues', VenueController::class)
    ->except(['show'])
    ->middleware(['auth', 'role:admin']);

Route::resource('events', EventController::class)->except(['show'])->middleware('auth');

require __DIR__.'/auth.php';
