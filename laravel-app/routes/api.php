<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ResultController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/results', [ResultController::class, 'store']);
    Route::get('/results', [ResultController::class, 'index']);
    Route::get('/results/{id}', [ResultController::class, 'show']);
    Route::get('/stats', [ResultController::class, 'stats']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
