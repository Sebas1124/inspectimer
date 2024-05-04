<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('index');

Auth::routes();

Route::middleware('auth')->middleware('can:admin.index')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Agrupa todas las rutas de admin bajo el middleware auth
Route::middleware('auth')->middleware('can:admin.index')->prefix('admin')->name('admin.')->group(function () {
    
    Route::prefix('users')->middleware('can:admin.index')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\UsersController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\UsersController::class, 'store'])->name('store');
        Route::GET('/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('edit');
        Route::POST('/update/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('update');
        Route::DELETE('/destroy/{id}', [App\Http\Controllers\UsersController::class, 'destroy'])->name('destroy');
    });

});

Route::get('/login/otp', [App\Http\Controllers\UserLoginController::class, 'index'])->name('login.otp');
Route::POST('/login/otp/verify', [App\Http\Controllers\UserLoginController::class, 'verify'])->name('login.verify');
Route::POST('/login/otp/confirm', [App\Http\Controllers\UserLoginController::class, 'confirm'])->name('login.confirm');
Route::get('/otp/verification', [App\Http\Controllers\OtpController::class, 'index'])->name('otp');


Route::get('/admin/employees', [App\Http\Controllers\SupervisorController::class, 'index'])
->middleware('auth')
->middleware('can:employees.index')
->name('employees.index');

Route::POST('/admin/employees/store', [App\Http\Controllers\SupervisorController::class, 'store'])
->middleware('auth')
->middleware('can:employees.store')
->name('employees.store');

Route::POST('/admin/employees/accept_hours', [App\Http\Controllers\SupervisorController::class, 'aceptarHoras'])
->middleware('auth')
->middleware('can:employees.store')
->name('employees.aceptarHoras');

Route::POST('/admin/employees/cancel_hours', [App\Http\Controllers\SupervisorController::class, 'cancelarHoras'])
->middleware('auth')
->middleware('can:employees.store')
->name('employees.cancelarHoras');

Route::get('/admin/reports', [App\Http\Controllers\reportsController::class, 'index'])
->middleware('auth')
->middleware('can:employees.store')
->name('employees.reports');

Route::get('/register', [App\Http\Controllers\UserLoginController::class, 'index'])->middleware('auth')->name('register');