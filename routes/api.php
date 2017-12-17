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
    $user = $request->user();
    return $user->_get_index();
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function() {
    Route::get('/{slug}', 'Api\ProfileController@index')->where('slug', '[0-9a-zA-Z-_]+');
});