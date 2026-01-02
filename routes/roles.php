<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RolesController;

Route::prefix('dashboard')->group(function () {
   Route::prefix('roles')->group(function () {
      Route::get('/', [RolesController::class, 'index'])->name('roles.index');
      Route::post('/', [RolesController::class, 'store'])->name('roles.store');
      Route::get('/create', [RolesController::class, 'create'])->name('roles.create');
      Route::get('/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
      Route::delete('/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
      Route::patch('/{id}', [RolesController::class, 'update'])->name('roles.update');
   });
})->middleware(['auth', 'verified'])->name('roles');