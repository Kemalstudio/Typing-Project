<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypingTestController;

Route::get('/', [TypingTestController::class, 'index']);
Route::post('/results', [TypingTestController::class, 'store'])->name('typing.results');
