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
})->name('games');

Route::middleware(['auth:sanctum', 'verified'])->get('/host', function () {
    return Inertia::render('Host/container');
})->name('host');

Route::middleware('auth:sanctum')->get('/game/rooms',[GameController::class , 'rooms']);

//HOST REQUESTS
Route::middleware('auth:sanctum')->get('/host/room/{roomId}/players',[GameController::class , 'players']);
Route::middleware('auth:sanctum')->post('/host/room/{roomId}/delete',[GameController::class , 'deletePlayer']);
Route::middleware('auth:sanctum')->post('/host/room/{roomId}/collectPlayers',[GameController::class , 'playerReadyConfirm']);
Route::middleware('auth:sanctum')->post('/host/room/{roomId}/resetRoom',[GameController::class , 'resestRoom']);
Route::middleware('auth:sanctum')->post('/host/room/{roomId}/startGame',[GameController::class , 'startGame']);

//PLAYER REQUESTS
Route::middleware('auth:sanctum')->post('/game/room/{roomId}/join',[GameController::class , 'newPlayer']);
Route::middleware('auth:sanctum')->get('/game/room/{roomId}/identity',[GameController::class , 'getOwnIdentity'])->name('identity');
Route::middleware('auth:sanctum')->get('/game/room/{roomId}/lobby',[GameController::class , 'lobby'])->name('lobby');
Route::middleware('auth:sanctum')->post('/game/room/{roomId}/confirmSelf',[GameController::class , 'confirmSelf']);
Route::middleware('auth:sanctum')->post('/game/room/{roomId}/deleteSelf',[GameController::class , 'deleteSelf']);










