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

Route::post('/hry/{id}/rezervovat', [HraController::class, 'rezervovat'])
    ->middleware('auth') // Důležité: Rezervovat může jen přihlášený!
    ->name('hry.rezervovat');

Route::get('/uzivatelsky-profil', [HraController::class, 'uzivatelskyProfil'])
    ->middleware('auth') // Důležité: Profil může zobrazit jen přihlášený!
    ->name('uzivatelsky-profil');

Route::get('/admin-profil', [HraController::class, 'adminProfil'])
    ->middleware('auth') // Důležité: Admin profil může zobrazit jen přihlášený!
    ->name('admin-profil');

Route::post('/hry/{id}/vratit', [HraController::class, 'vratit'])
    ->middleware('auth') // Důležité: Vrátit může jen přihlášený!
    ->name('hry.vratit');

Route::post('/hry/{id}/schvalit', [HraController::class, 'schvalit'])
    ->middleware('auth') // Důležité: Schválit může jen přihlášený!
    ->name('hry.schvalit');

Route::get('/sources', function () {
    return view('sources');
})->name('sources');