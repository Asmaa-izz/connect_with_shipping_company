<?php

use App\Http\Controllers\AreasController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\NeighborhoodsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WelcomeController::class, 'index']);

Auth::routes();



Route::middleware('auth:web')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::resource('/settings', SettingController::class)->only(['index', 'store']);
    Route::resource('/roles', RolesController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::resource('/employees', EmployeesController::class);
    Route::resource('/orders', OrdersController::class);

    Route::get('/shipping', [DashboardController::class, 'index'])->name('shipping');
    Route::resource('/cities', CitiesController::class)->except(['create', 'edit']);
    Route::resource('/areas', AreasController::class)->except(['create', 'edit']);
    Route::resource('/neighborhoods', NeighborhoodsController::class)->except(['create', 'edit']);

});
