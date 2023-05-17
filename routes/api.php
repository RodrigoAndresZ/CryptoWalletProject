<?php

use App\Infrastructure\Controllers\GetUserController;
use App\Infrastructure\Controllers\IsEarlyAdopterUserController;
use App\Infrastructure\Controllers\GetStatusController;
use App\Infrastructure\Persistence\CreateWalletController;
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


Route::get('/status', GetStatusController::class);
Route::get('/users/{userEmail}', GetUserController::class);
//Route::get('/coin/buy/{coin_id}/{wallet_id}/{amount_usd}', BuyCoinController::class);

//Route::post('/wallet/open', CreateWalletController::class);

Route::get('/wallet/{wallet_id}',\App\Infrastructure\Controllers\GetWalletController::class);
