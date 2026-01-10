<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;

Route::prefix('dashboard')->group(function () {
   Route::prefix('roles')->group(function () {
      Route::get('/', [RolesController::class, 'index'])->name('roles.index');
      Route::post('/', [RolesController::class, 'store'])->name('roles.store');
      Route::get('/create', [RolesController::class, 'create'])->name('roles.create');
      Route::get('/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
      Route::delete('/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
      Route::patch('/{id}', [RolesController::class, 'update'])->name('roles.update');
   });

   Route::prefix('permissions')->group(function () {
      Route::get('/', [PermissionsController::class, 'index'])->name('permissions.index');
      Route::post('/', [PermissionsController::class, 'store'])->name('permissions.store');
      Route::get('/create', [PermissionsController::class, 'create'])->name('permissions.create');
      Route::get('/{id}/edit', [PermissionsController::class, 'edit'])->name('permissions.edit');
      Route::delete('/{id}', [PermissionsController::class, 'destroy'])->name('permissions.destroy');
      Route::patch('/{id}', [PermissionsController::class, 'update'])->name('permissions.update');
   });
})->middleware(['auth', 'verified'])->name('roles');