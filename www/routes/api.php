<?php

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

Route::apiResource('users', 'UserController');
Route::prefix('users')->group(function () {
    Route::get('{id}/favorites', 'UserController@favorites');
});
Route::apiResource('categories', 'CategoryController');
Route::apiResource('songs', 'SongController');
Route::prefix('songs')->group(function () {
    Route::get('{id}/favorites', 'SongController@favorites');
    Route::post('{id}/favorites', 'SongController@storeFavorites');
    Route::delete('{id}/favorites', 'SongController@deleteFavorites');
});

