<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', 'App\Http\Controllers\DashboardController@show')
        ->name('dashboard');
    Route::get('admin/user/list', 'App\Http\Controllers\AdminUserController@list');
    Route::get('admin/user/add', 'App\Http\Controllers\AdminUserController@add');
    Route::post('admin/user/store', 'App\Http\Controllers\AdminUserController@store');
    
});


require __DIR__ . '/auth.php';
