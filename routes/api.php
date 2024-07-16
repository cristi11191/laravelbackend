<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
Route::middleware('isAuthApi')->group(function () {
    Route::get('current-user', 'App\Http\Controllers\AuthController@getCurrentUser');
});
Route::middleware(['isAuthApi', 'role:Admin'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

});
