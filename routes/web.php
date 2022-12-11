<?php

use App\Http\Controllers\MovieController;

Route::group(["prefix" => "Movies"], function () {
    Route::get('/', [MovieController::class, 'getList']);
    Route::get('/{id}', [MovieController::class, 'getDetail']);
    Route::post('/', [MovieController::class, 'addMovie']);
    Route::patch('/{id}', [MovieController::class, 'updateMovie']);
    Route::delete('/{id}', [MovieController::class, 'deleteMovie']);
});

Route::get('/token', function () {
    return csrf_token(); 
});