<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MerchantController;
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

// B2C

Route::post("/mpesa/payment/request", [
    "as" => "mpesa.paymentRequest",
    "uses" => "\App\Http\Controllers\MPESA\MpesaController@paymentRequest"
]);

Route::post("/b2c/result", [
    "as" => "b2c.result",
    "uses" => "\App\Http\Controllers\MPESA\MpesaController@B2CResultResponse"
]);

Route::post("/b2c/timeout", [
    "as" => "b2c.timeout",
    "uses" => "\App\Http\Controllers\MPESA\MpesaController@B2CTimeoutResponse"
]);

//Mpesa
Route::post("mpesa/deposit", [
    "as" => "mpesa.lipanampesa",
    "uses" => "\App\Http\Controllers\MPESA\DepositController@lipaNaMpesa"
]);

Route::post("mpesaipn", [
    "as" => "mpesa.payment",
    "uses" => "\App\Http\Controllers\MPESA\DepositController@mpesaIPN"
]);

/*
|--------------------------------------------------------------------------
| Merchant API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('merchant')->group(function () {
    Route::post('login', [MerchantController::class, 'login']);
    Route::get('pay/all/{id}/{type}', [MerchantController::class,'payAll']);
Route::middleware('auth:api')->group( function () {
    Route::get('accountbalance/{id}', [MerchantController::class,'accountBalance']);
    Route::get('catalog/{id}', [MerchantController::class,'catalog']);
    Route::get('browse/{id}', [MerchantController::class,'browse']);
    Route::get('requested/{id}', [MerchantController::class,'requested']);
    Route::get('received/{id}', [MerchantController::class,'received']);
    Route::post('assetrequest', [MerchantController::class, 'assetRequest']);
    Route::get('orderassetstatus/{id}/{user_id}/{status}', [MerchantController::class, 'orderAssetStatus']);
    Route::get('myassets/{id}', [MerchantController::class, 'myAssets']);
    Route::get('ongoingassetstats/{id}', [MerchantController::class, 'ongoingAssetStats']);
    Route::get('defaultedassetstats/{id}', [MerchantController::class, 'defaultedAssetStats']);
    Route::get('completedassetstats/{id}', [MerchantController::class, 'completedAssetStats']);
    Route::get('completedassetdetails/{order_id}', [MerchantController::class, 'completedAssetDetails']);
    Route::get('transactions/{user_id}', [MerchantController::class, 'transactions']);
    Route::get('transactiondetails/{order_id}', [MerchantController::class, 'transactionDetails']);
    Route::get('paymentstats/{id}', [MerchantController::class,'paymentStats']);
    Route::get('paymentconfirmation/{id}/{type}', [MerchantController::class,'paymentConfirmation']);
    Route::get('pay/now/{invoice_id}/{merchant_id}', [MerchantController::class,'payNow']);
    });
});