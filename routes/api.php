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
    // Route::get('/{slug}', 'Api\ProfileController@index')->where('slug', '[0-9a-zA-Z-_]+');
    Route::post('/update_profile', 'Api\ProfileController@update')->where('slug', '[0-9a-zA-Z-_]+');
    Route::group(['prefix' => 'media'], function() {
        Route::post('/upload', 'Api\MediaController@upload');
        Route::post('/destroy', 'Api\MediaController@destroy');
    });    

    Route::post('check_following', 'Api\FriendshipController@check_following');
    Route::post('add_following', 'Api\FriendshipController@add_following');
    Route::post('remove_following', 'Api\FriendshipController@remove_following');
});

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function() {
    Route::get('/{slug}', 'Api\ProfileController@index')->where('slug', '[0-9a-zA-Z-_]+');
});