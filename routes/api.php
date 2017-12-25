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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     $user = $request->user();
//     return $user->_get_index();
// });

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function() {
    Route::get('/user', 'Api\ProfileController@getAuth');
    Route::post('/update_profile', 'Api\ProfileController@update')->where('slug', '[0-9a-zA-Z-_]+');
    Route::group(['prefix' => 'media'], function() {
        Route::post('/upload', 'Api\MediaController@upload');
        Route::post('/delete', 'Api\MediaController@destroy');
        Route::get('/list', 'Api\MediaController@list');
        Route::get('/get_image/{id}', 'Api\MediaController@get_image');
    });    

    Route::post('/post/store', 'Api\ProductController@store')->name('product.store');
    Route::post('/post/update', 'Api\ProductController@update')->name('product.update');
    Route::post('/post/get_product', 'Api\ProductController@get_index')->name('product.get_index');

    Route::post('check_following', 'Api\FriendshipController@check_following');
    Route::post('add_following', 'Api\FriendshipController@add_following');
    Route::post('remove_following', 'Api\FriendshipController@remove_following');
});

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function() {
    Route::get('/{slug}', 'Api\ProfileController@index')->where('slug', '[0-9a-zA-Z-_]+');
});