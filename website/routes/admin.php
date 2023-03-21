<?php

use App\Http\Controllers\Admin\ContactCompanyController;
use App\Http\Controllers\Admin\ContactContactController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

// Permissions
Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
Route::resource('permissions', PermissionController::class, ['except' => ['store', 'update', 'destroy']]);

// Roles
Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
Route::resource('roles', RoleController::class, ['except' => ['store', 'update', 'destroy']]);

// Users
Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
Route::resource('users', UserController::class, ['except' => ['store', 'update', 'destroy']]);

// Contact Company
Route::resource('contact-companies', ContactCompanyController::class, ['except' => ['store', 'update', 'destroy']]);

// Contact Contacts
Route::resource('contact-contacts', ContactContactController::class, ['except' => ['store', 'update', 'destroy']]);

// Transactions
Route::resource('transactions', TransactionController::class, ['except' => ['store', 'update', 'destroy']]);
