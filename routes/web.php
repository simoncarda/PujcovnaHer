<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HraController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HraController::class, 'pageDashboard'])->name('dashboard');
});

Route::get('/hry', [HraController::class, 'index'])->name('hry.index');
Route::get('/hry/{id}', [HraController::class, 'show'])->name('hry.show');