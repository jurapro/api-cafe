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

        Route::apiResource('work-shift', Controllers\WorkShiftController::class, ['only' => ['index', 'store']]);
    });

