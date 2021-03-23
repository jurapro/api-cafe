<?php

use App\Http\Controllers;
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

Route::get('/user', [Controllers\UserController::class, 'index']);
Route::post('/user', [Controllers\UserController::class, 'store'])
    ->middleware(['auth:api','role:admin']);

/*Route::middleware('auth:api')
    ->resource('order', Controllers\OrderController::class, ['only' => ['store', 'index']]);

Route::get('/order/{order}', [Controllers\OrderController::class, 'show']);*/

