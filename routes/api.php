<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\PubController;
use App\Http\Controllers\RatingController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function () {

    Route::group(['prefix' => 'pub'], function () {
        Route::post('create', [PubController::class, 'create']);
        Route::get('{pub}/get', [PubController::class, 'get']);
        Route::get('store', [PubController::class, 'store']);
        Route::get('store_my_pub', [PubController::class, 'storeMyPub']);
        Route::post('{pub}/rating/create', [RatingController::class, 'create']);
    });

    Route::group(['prefix' => 'dish'], function () {
        Route::get('store', [DishController::class, 'store']);
        Route::post('{dish}/add', [DishController::class, 'add']);
        Route::post('create', [DishController::class, 'create']);
    });
});
