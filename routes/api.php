<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware('isAuthApi')->group(function () {
    Route::get('current-user', [AuthController::class, 'getCurrentUser']);
    Route::post('register', [AuthController::class, 'register'])->middleware('role:Admin');

    Route::get('users', [UserController::class, 'index'])->middleware('role:Admin');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('role:Admin');
    Route::post('users', [UserController::class, 'store'])->middleware('role:Admin');
    Route::put('users/{id}', [UserController::class, 'update'])->middleware('role:Admin');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('role:Admin');

    Route::get('roles', [RoleController::class, 'all'])->middleware('role:Admin');
    Route::get('roles/{id}', [RoleController::class, 'show'])->middleware('role:Admin');
    Route::post('roles', [RoleController::class, 'store'])->middleware('role:Admin');
    Route::put('roles/{id}', [RoleController::class, 'update'])->middleware('role:Admin');
    Route::delete('roles/{id}', [RoleController::class, 'destroy'])->middleware('role:Admin');
    Route::get('roles/{id}/permissions', [RoleController::class, 'getPermissions'])->middleware('role:Admin');

    Route::get('groups', [GroupController::class, 'all'])->middleware('role:Admin,Secretary');
    Route::get('groups/{id}', [GroupController::class, 'get'])->middleware('role:Admin,Secretary');
    Route::post('groups', [GroupController::class, 'create'])->middleware('role:Admin,Secretary');
    Route::put('groups/{id}', [GroupController::class, 'update'])->middleware('role:Admin,Secretary');
    Route::delete('groups/{id}', [GroupController::class, 'delete'])->middleware('role:Admin,Secretary');

    Route::get('series', [SeriesController::class, 'index'])->middleware('role:Admin,Secretary');
    Route::post('series', [SeriesController::class, 'store'])->middleware('role:Admin,Secretary');
    Route::put('series/{series}', [SeriesController::class, 'update'])->middleware('role:Admin,Secretary');
    Route::delete('series/{series}', [SeriesController::class, 'destroy'])->middleware('role:Admin,Secretary');
    Route::post('series/{seriesId}/add-group', [SeriesController::class, 'addGroupToSeries'])->middleware('role:Admin,Secretary');
    Route::post('series/{seriesId}/remove-group', [SeriesController::class, 'removeGroupFromSeries'])->middleware('role:Admin,Secretary');
    Route::delete('groups/{groupId}/delete-from-series', [SeriesController::class, 'deleteGroupFromAllSeries'])->middleware('role:Admin,Secretary');

});





