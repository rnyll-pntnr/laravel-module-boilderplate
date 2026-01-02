<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UsersController;

Route::prefix('dashboard')->group(function () {
   Route::prefix('users')->group(function () {
      Route::get('/', [UsersController::class, 'index'])->name('users.index');
      Route::post('/', [UsersController::class, 'store'])->name('users.store');
      Route::get('/create', [UsersController::class, 'create'])->name('users.create');
      Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
      Route::delete('/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
      Route::patch('/{id}', [UsersController::class, 'update'])->name('users.update');
   });
})->middleware(['auth', 'verified'])->name('users');