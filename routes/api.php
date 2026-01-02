<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    UserController,
    RolesController
};

// Public routes
Route::group(['middleware' => 'guest'], function () {
    // Token Generation / Login
    Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate.grant');

    // User Registration
    Route::prefix('user')->group(function () {
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
    });
});


Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('api.users.index');
})->middleware('auth:sanctum');

Route::prefix('roles')->group(function () {
    Route::get('/', [RolesController::class, 'index'])->name('api.roles.index');
})->middleware('auth:sanctum');