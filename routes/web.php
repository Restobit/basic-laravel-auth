<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\UserController as AdminUsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);


Route::middleware(['accepted', 'verified', 'auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['accepted'])->name('home');

    Route::middleware(['hasRole:admin'])->prefix('admin')->name('admin.')->group(function () {

        Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

        Route::resource('/users', AdminUsersController::class);
    });
});




