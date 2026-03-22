<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(WebhookController::class)->group(function () {
    Route::post('/webhook/hyperfast', 'handleWebhookHyperfast')->name('handleWebhookHyperfast');
    Route::post('/webhook/hub2', 'handleWebhookHub2')->name('handleWebhookHub2');
});

Route::controller(TestController::class)->group(function () {
    Route::get('/test_hub2_payment', 'testHub2payment')->name('testHub2payment');
    Route::get('/test_hub2_check', 'testHub2Verification')->name('testHub2Verification');
    Route::get('/test_hub2_webhook', 'testHub2webhook')->name('testHub2webhook');
    Route::get('/reload_check_status_hub2', 'reloadCheckStatusHub2')->name('reloadCheckStatusHub2');
    Route::get('/test_process_vote', 'testProcessVote')->name('testProcessVote');
    Route::get('/test_paystack_payment', 'testPaystackpayment')->name('testPaystackpayment');
    Route::get('/test_hyperfast_payment', 'testHyperfast')->name('testHyperfast');
    Route::get('/check_status_transaction', 'checkStatusTransaction')->name('checkStatusTransaction');

});
