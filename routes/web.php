<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VenueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaEventoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscricaoController;


Route::get('/', function () {
    return to_route('eventos.index');
});


Route::resource('categorias-eventos', CategoriaEventoController::class)
    ->parameters([
        'categorias-eventos' => 'categoriaEvento',
    ])
    ->except(['show'])
    ->middleware(['auth', 'role:admin']);

Route::resource('eventos', EventoController::class)
    ->except(['index', 'show'])
    ->middleware('auth');

Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{evento}', [EventoController::class, 'show'])->name('eventos.show');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/eventos/{evento}/participantes', [InscricaoController::class, 'participantes'])
        ->name('eventos.participantes');

    Route::delete('/inscricoes/{inscricao}', [InscricaoController::class, 'destroy'])
        ->name('inscricoes.destroy');

    Route::post('/eventos/{evento}/inscricoes', [InscricaoController::class, 'store'])
        ->name('inscricoes.store');

    Route::get('/minhas-inscricoes', [InscricaoController::class, 'minhasInscricoes'])
        ->name('inscricoes.minhas');

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
