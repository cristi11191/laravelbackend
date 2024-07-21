<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

    Route::get('roles', [RoleController::class, 'all'])->middleware('permission:read_role');
    Route::get('roles/{id}', [RoleController::class, 'show'])->middleware('permission:read_role');
    Route::post('roles', [RoleController::class, 'store'])->middleware('permission:create_role');
    Route::put('roles/{id}', [RoleController::class, 'update'])->middleware('permission:update_role');
    Route::delete('roles/{id}', [RoleController::class, 'destroy'])->middleware('permission:delete_role');
    Route::get('roles/{id}/permissions', [RoleController::class, 'getPermissions'])->middleware('permission:read_role');


    Route::get('permissions', [PermissionController::class, 'all'])->middleware('permission:read_permission');
    Route::get('permissions/{id}', [PermissionController::class, 'show'])->middleware('permission:read_permission');
    Route::post('permissions', [PermissionController::class, 'store'])->middleware('permission:create_permission');
    Route::put('permissions/{id}', [PermissionController::class, 'update'])->middleware('permission:update_permission');
    Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])->middleware('permission:delete_user');

    Route::post('register', [AuthController::class, 'register']);
});



