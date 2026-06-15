<?php

use App\Http\Controllers\GamesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/videojuegos');

Route::get('/videojuegos', [GamesController::class, 'index'])->name('juegos.index');
Route::get('/juegos/{slug}', [GamesController::class, 'show'])->name('juegos.show');
