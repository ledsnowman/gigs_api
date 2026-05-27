<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GigsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;

// Публичный маршрут для входа
Route::post('/login', [ LoginController::class, 'login' ]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Получение списка категорий
    Route::get('/categories', [ CategoryController::class, 'index' ]);

    // Получение списка событий (с фильтрами и пагинацией)
    Route::get('/gigs', [ GigsController::class, 'index' ]);

    // Выход из системы (отзыв токена)
    Route::post('/logout', [ LoginController::class, 'logout' ]);
});
