<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh',[AuthController::class, 'refresh']);
Route::middleware('isAuthApi')->group(function () {
    Route::get('current-user', [AuthController::class, 'getCurrentUser']);
});

Route::group(['middleware' => ['isAuthApi', 'permission:view_dashboard']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::group(['middleware' => ['isAuthApi','role:Admin']], function () {
    Route::get('users', [UserController::class, 'index'])->middleware('permission:read_user');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('permission:read_user');
    Route::post('users', [UserController::class, 'store'])->middleware('permission:create_user');
    Route::put('users/{id}', [UserController::class, 'update'])->middleware('permission:update_user');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('permission:delete_user');
    Route::post('register', [AuthController::class, 'register']);
});



