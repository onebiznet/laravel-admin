<?php

use Illuminate\Support\Facades\Route;
use OneBiznet\Admin\Controllers\RoleController;
use OneBiznet\Admin\Controllers\UserController;

Route::name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin::home');
    })->name('home');

    Route::prefix('users')
        ->name('users.')
        ->controller(UserController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'edit')->name('create');
            Route::get('/edit/{row}', 'edit')->name('edit');
        });

    Route::prefix('roles')
        ->name('roles.')
        ->controller(RoleController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'edit')->name('create');
            Route::get('/edit/{row}', 'edit')->name('edit');
        });
});
