<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('index');

Auth::routes();

Route::middleware('auth')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Agrupa todas las rutas de admin bajo el middleware auth
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\UsersController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\UsersController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('edit');
        Route::get('/destroy/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('destroy');
    });

});

Route::get('/admin/employees', [App\Http\Controllers\SupervisorController::class, 'index'])->name('employees.index');
Route::POST('/admin/employees/store', [App\Http\Controllers\SupervisorController::class, 'store'])->name('employees.store');