<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', \App\Http\Controllers\User\Auth\RegisterController::class);
Route::post('forget-password', \App\Http\Controllers\User\Auth\ForgetPasswordController::class);
Route::post('verify-otp', [\App\Http\Controllers\OTPController::class, 'verify']);
Route::post('reset-password', \App\Http\Controllers\User\Auth\ResetPasswordController::class);

Route::post('login', \App\Http\Controllers\User\Auth\LoginController::class);

Route::group(['middleware' => ['auth:sanctum', 'verify_user']], function(){
    Route::get('wallet/{User:uuid}/details', [\App\Http\Controllers\User\WalletController::class, 'details']);
    Route::get('wallet/{User:uuid}/stats', [\App\Http\Controllers\User\WalletController::class, 'stats']);
    Route::get('wallet/{User:uuid}/transactions', [\App\Http\Controllers\User\WalletController::class, 'transactions']);
    Route::get('wallet/transactions/{WalletTransaction:uuid}/details', [\App\Http\Controllers\User\WalletTransactionController::class, 'details']);
    Route::get('{User:uuid}/notifications', [\App\Http\Controllers\User\NotificationController::class, 'show']);
    Route::get('user/{User:uuid}/profile', [\App\Http\Controllers\User\UserController::class, 'profile']);
    Route::patch('user/{User:uuid}/change-password', [\App\Http\Controllers\User\UserController::class, 'changePassword']);


    Route::get('bill/network-category', [\App\Http\Controllers\User\BillPaymentController::class, 'airtimeCategory']);
    Route::get('bill/data-plans', [\App\Http\Controllers\User\BillPaymentController::class, 'dataPlans']);
    Route::get('bill/data-plans/category', [\App\Http\Controllers\User\BillPaymentController::class, 'dataPlansCategory']);

    Route::post('bill/purchase', [\App\Http\Controllers\User\BillPaymentController::class, 'purchase']);


});

Route::post('support', [\App\Http\Controllers\SupportController::class, 'update']);
Route::get('support', [\App\Http\Controllers\SupportController::class, 'index']);
Route::put('webhook', [\App\Http\Controllers\User\WalletController::class, 'webhook']);
