<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
Use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/games', function () {
    return Inertia::render('Player/container');
})->name('game');

Route::middleware(['auth:sanctum', 'verified'])->get('/host', function () {
    return Inertia::render('Host/container');
})->name('host');

Route::middleware('auth:sanctum')->get('/game/rooms',[GameController::class , 'rooms']);
Route::middleware('auth:sanctum')->get('/host/room/{roomId}/players',[GameController::class , 'rooms']);
Route::middleware('auth:sanctum')->get('/game/room/{roomId}/join',[GameController::class , 'newPlayer']);
