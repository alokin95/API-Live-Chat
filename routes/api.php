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

Route::post('/test', function()
{
    return auth()->user();
});


Route::get('/', 'HomeController@index');
Route::post('/users', 'AuthController@store');
Route::post('/login', 'AuthController@login');

Route::middleware('jwt.auth')->group(function()
{
    Route::get('/contacts', 'UserController@contacts');
    Route::get('/messages', 'MessageController@index');
    Route::post('/messages', 'MessageController@store');

});