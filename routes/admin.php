<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\LogoutController;
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

Route::group(['prefix' => 'admin'], function(){
    Route::post('login', LoginController::class);

    Route::group(['middleware' => ['auth:sanctum', 'verify_admin']], function(){
        Route::controller(\App\Http\Controllers\Admin\UserController::class)->group(function() {
            Route::get('users', 'index');
            Route::patch('users/{user:uuid}/status', 'suspend');
            Route::delete('users/{user:uuid}/delete', 'delete');
            Route::patch('users/{user:uuid}/restore', 'restore');
            Route::get('users/deleted','deletedList');
        });

        Route::controller(\App\Http\Controllers\Admin\TransactionController::class)->group(function(){
            Route::get('transactions', 'index');
            Route::get('transactions/{Transaction:id}/details', 'show');
            Route::get('transactions/{User:uuid}/user', 'user');
        });

        Route::controller(\App\Http\Controllers\Admin\WalletTransactionController::class)->group(function(){
            Route::get('wallet-transactions', 'index');
            Route::get('wallet-transactions/{Transaction:id}/details', 'show');
            Route::get('wallet-transactions/{User:uuid}/user', 'user');
        });


    });
});




// Route::post('support', [\App\Http\Controllers\SupportController::class, 'update']);
// Route::get('support', [\App\Http\Controllers\SupportController::class, 'index']);
// Route::put('webhook', [\App\Http\Controllers\User\WalletController::class, 'webhook']);
