<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

/* Route::group(['middleware'=>['role:super-admin|Admin']], function(){ */

    Route::group(['middleware'=>['isAdmin']], function(){
    // Permission Routes
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    // Role Routes
    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy'])->middleware('permission:Delete Role'); 
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'givePermission']);
    Route::put('roles/{roleId}/update-permissions', [RoleController::class, 'updatePermissionToRole']);


    //users Routes
    Route::resource('users', UserController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);
    Route::resource('users', UserController::class);

    });

    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/archive', [TaskController::class, 'archive'])->name('tasks.archive');
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
