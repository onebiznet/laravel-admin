<?php

use Illuminate\Support\Facades\Route;
use OneBiznet\Admin\Controllers\PermissionController;
use OneBiznet\Admin\Controllers\RoleController;
use OneBiznet\Admin\Controllers\UserController;

Route::name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin::home');
    })->name('home');

    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
        'controller' => UserController::class,
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'edit')->name('create');
        Route::get('/edit/{row}', 'edit')->name('edit');
    });

    Route::group([
        'prefix' => 'roles',
        'as' => 'roles.',
        'controller' => RoleController::class
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'edit')->name('create');
        Route::get('/edit/{row}', 'edit')->name('edit');
    });

    Route::group([
        'prefix' => 'permissions',
        'as' => 'permissions.',
        'controller' => PermissionController::class,
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'edit')->name('create');
        Route::get('/edit/{row}', 'edit')->name('edit');
    });
});
