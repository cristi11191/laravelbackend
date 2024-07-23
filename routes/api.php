<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh',[AuthController::class, 'refresh']);
Route::middleware('isAuthApi')->group(function () {
    Route::get('current-user', [AuthController::class, 'getCurrentUser']);

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
    Route::put('/roles/{id}/permissions', [RoleController::class, 'updatePermissions'])->middleware('permission:update_role');


    Route::get('permissions', [PermissionController::class, 'all'])->middleware('permission:read_permission');
    Route::get('permissions/{id}', [PermissionController::class, 'show'])->middleware('permission:read_permission');
    Route::post('permissions', [PermissionController::class, 'store'])->middleware('permission:create_permission');
    Route::put('permissions/{id}', [PermissionController::class, 'update'])->middleware('permission:update_permission');
    Route::delete('permissions/{id}', [PermissionController::class, 'destroy'])->middleware('permission:delete_user');

    Route::post('/role-permissions', [RolePermissionController::class, 'store'])->middleware('permission:update_role');
    Route::delete('/role-permissions', [RolePermissionController::class, 'destroy'])->middleware('permission:update_role');

    Route::post('register', [AuthController::class, 'register']);
});




