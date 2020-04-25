<?php

use Illuminate\Http\Request;
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


Route::post('/sendsms', 'UserController@getCode'); // phone
Route::post('/register', 'UserController@register'); // phone,code,name
Route::post('/gettoken', 'ApiTokenController@update')->name('gettoken'); // user_id

Route::middleware('auth:api')->group(function () {
    Route::post('/activate', 'ActivationController@create');
    Route::post('/show', 'ActivationController@show');
    Route::get('/user', function ()
    {
      return response()->json(['user'=>Auth()->user()]);
    });
});
