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

Route::post('/login', [Controllers\UserController::class, 'login']);
Route::middleware('auth:api')->get('/logout', [Controllers\UserController::class, 'logout']);

Route::middleware(['auth:api', 'role:admin'])
    ->group(function () {
        Route::apiResource('user', Controllers\UserController::class, ['only' => ['show', 'index', 'store']]);
        Route::get('/user/{user}/to-dismiss', [Controllers\UserController::class, 'toDismiss']);

        Route::apiResource('work-shift', Controllers\WorkShiftController::class, ['only' => ['index', 'store', 'show']]);
        Route::get('/work-shift/{workShift}/open', [Controllers\WorkShiftController::class, 'open']);
        Route::get('/work-shift/{workShift}/close', [Controllers\WorkShiftController::class, 'close']);
        Route::post('/work-shift/{workShift}/user', [Controllers\WorkShiftController::class, 'addUser']);
        Route::delete('/work-shift/{workShift}/user/{user}', [Controllers\WorkShiftController::class, 'removeUser']);
    });

Route::middleware(['auth:api', 'role:admin|waiter'])
    ->group(function () {
        Route::get('/work-shift/{workShift}/orders', [Controllers\WorkShiftController::class, 'orders']);
        Route::apiResource('order', Controllers\OrderController::class, ['only' => ['index', 'show']]);
    });
