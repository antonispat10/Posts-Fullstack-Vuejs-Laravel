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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('posts','PostsController@index');
Route::get('post/{id}','PostsController@show');

Route::post('post/{id}','PostsController@store');

Route::get('post/edit/{id}','PostsController@show');

Route::put('post/{id}/edit','PostsController@update');

Route::delete('post/{id}','PostsController@destroy');



