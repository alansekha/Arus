<?php

use Illuminate\Http\Request;

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


Route::group(['prefix'=>'authentication'], function(){
    Route::post('register', 'Api\userController@register');
    Route::post('login', 'Api\userController@login');
    Route::get('user', 'Api\userController@getAuthenticatedUser')->middleware('jwt.verify');
});
