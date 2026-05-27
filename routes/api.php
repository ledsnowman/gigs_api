<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GigsController;
use App\Http\Controllers\Auth\LoginController;

// Публичный маршрут для входа
Route::post('/login', [ LoginController::class, 'login' ]);

// Защищенный маршрут для выхода
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ LoginController::class, 'logout' ]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/gigs', [ GigsController::class, 'index' ])
    ->middleware('auth:sanctum');
