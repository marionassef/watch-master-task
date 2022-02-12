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

#### Cart Routes
Route::prefix('v1/cart')->group(function () {
    Route::post('store', [CartController::class, 'store'])->name('cart.store');
    Route::get('details/{user_id}', [CartController::class, 'details'])->name('cart.details');
    Route::post('buy', [CartController::class, 'buyItem'])->name('cart.buy.item');
});
