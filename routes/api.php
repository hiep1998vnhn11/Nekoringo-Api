<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\PubController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Models\Category;

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
    Route::post('update', [UserController::class, 'update']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function () {

    Route::group(['prefix' => 'pub'], function () {
        Route::post('create', [PubController::class, 'create']);
        Route::get('{pub}/get', [PubController::class, 'get']);
        Route::post('{pub}/update', [PubController::class, 'update']);
        Route::post('{pub}/delete', [PubController::class, 'delete']);
        Route::get('store', [PubController::class, 'store']);
        Route::get('store_my_pub', [PubController::class, 'storeMyPub']);
        Route::post('{pub}/rating/create', [RatingController::class, 'create']);
        Route::post('{pub}/comment/create', [CommentController::class, 'create']);
        Route::get('{pub}/dish/store', [PubController::class, 'storeDish']);
        Route::post('{pub}/dish/change', [PubController::class, 'changeDish']);
        Route::post('{pub}/dish/{dish}/add', [PubController::class, 'addDish']);
        Route::post('{pub}/dish/{dish}/delete', [PubController::class, 'deleteDish']);
    });

    Route::group(['prefix' => 'dish'], function () {
        Route::get('store', [DishController::class, 'store']);
        Route::post('{dish}/add', [DishController::class, 'add']);
        Route::get('{dish}/pub/store', [DishController::class, 'storePub']);
        Route::post('create', [DishController::class, 'create']);
    });

    Route::post('rating/{rating}/delete', [RatingController::class, 'delete']);
    Route::post('comment/{comment}/delete', [CommentController::class, 'delete']);

    Route::group(['prefix' => 'category'], function () {
        Route::get('store', [CategoryController::class, 'store']);
        Route::get('{category}/get', [CategoryController::class, 'get']);
        Route::post('create', [CategoryController::class, 'create']);
        Route::post('{category}/delete', [CategoryController::class, 'delete']);
    });
});
