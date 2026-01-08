<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Socialite\Socialite;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/login/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::prefix('auth')->group(function () {
    Route::prefix('google')->group(function () {
        Route::get('/callback', [UsersController::class, 'googleAuthProvider'])->name('login.googleCallback');
    });
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/users.php';
require __DIR__.'/roles.php';