<?php

use App\Http\Controllers\Business\BusinessController;
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
    Route::post('login', 'login');
    Route::get('/confirm/{id}/{token}', 'confirm')->name('confirm');
});


Route::group(['middleware' => 'auth'], function () {
    Route::controller(ConsoleController::class)->group(function () {
        Route::get('back_office_console', 'index')->name('back_office_console');
        Route::get('list_customer', 'listCustomer')->name('list_customer');
        Route::get('parametre_compte', 'parametreCompte')->name('parametre_compte');
        Route::get('list_campagne', 'listCampagne')->name('list_campagne');
    });

    Route::controller(BusinessController::class)->group(function () {
        Route::get('back_office_business', 'index')->name('back_office_business');
        Route::get('parametre_compte', 'parametreCompte')->name('parametre_compte');
        Route::get('list_candidat', 'listCandidat')->name('list_candidat');
        Route::get('list_vote', 'listVote')->name('list_vote');
        Route::get('list_retrait', 'listRetrait')->name('list_retrait');
    });
});
