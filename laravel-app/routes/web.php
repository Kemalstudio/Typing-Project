<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypingTestController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', [TypingTestController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/results', [TypingTestController::class, 'store'])->name('typing.results');
    Route::get('/stats', [TypingTestController::class, 'stats'])->name('stats');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/results', [DashboardController::class, 'results'])->name('results');
    Route::get('/user/{user}/results', [DashboardController::class, 'userResults'])->name('user.results');
    Route::delete('/result/{id}', [DashboardController::class, 'deleteResult'])->name('delete.result');
    Route::delete('/user/{id}', [DashboardController::class, 'deleteUser'])->name('delete.user');
});

require __DIR__.'/auth.php';
