<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Console\ConsoleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
Route::get('/', function () {
    return view('welcome');
});
*/



Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'screenLogin')->name('screenLogin');
    Route::post('registered', 'register');
    Route::get('/confirm/{id}/{token}','confirm')->name('confirm');
});

Route::controller(ConsoleController::class)->group(function () {
    Route::get('back_office_console', 'index')->name('index');

});
