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
        Route::prefix('work-shift')->group(function () {
            Route::get('/{workShift}/open', [Controllers\WorkShiftController::class, 'open']);
            Route::get('/{workShift}/close', [Controllers\WorkShiftController::class, 'close']);
            Route::post('/{workShift}/user', [Controllers\WorkShiftController::class, 'addUser']);
            Route::delete('/{workShift}/user/{user}', [Controllers\WorkShiftController::class, 'removeUser']);
        });
    });

Route::middleware(['auth:api', 'role:admin|waiter'])
    ->group(function () {
        Route::get('/work-shift/active/get', [Controllers\WorkShiftController::class, 'active']);
        Route::get('/work-shift/{workShift}/order', [Controllers\WorkShiftController::class, 'orders']);
        Route::apiResource('order', Controllers\OrderController::class, ['only' => ['index', 'show']]);
        Route::get('/table', [Controllers\TableController::class, 'index']);
    });

Route::middleware(['auth:api', 'role:waiter'])->prefix('order')
    ->group(function () {
        Route::post('/', [Controllers\OrderController::class, 'store']);
        Route::post('/{order}/position', [Controllers\OrderController::class, 'addPosition']);
        Route::delete('/{order}/position/{orderMenu}', [Controllers\OrderController::class, 'removePosition']);
    });

Route::middleware(['auth:api', 'role:waiter|cook'])
    ->group(function () {
        Route::patch('/order/{order}/change-status', [Controllers\OrderController::class, 'changeStatus']);
    });

Route::middleware(['auth:api', 'role:cook'])->prefix('order')
    ->group(function () {
        Route::get('/taken/get', [Controllers\OrderController::class, 'takenOrders']);
    });
