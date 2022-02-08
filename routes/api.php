<?php

use App\Http\Controllers\CartController;
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

Route::post('cart/store', [CartController::class, 'store']);
Route::post('cart/get', [CartController::class, 'getCart']);
Route::post('product/buy', [CartController::class, 'buyProduct']);
