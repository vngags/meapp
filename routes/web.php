<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/{provider}', 'SocialController@redirectToProvider');
Route::get('auth/{provider}/callback', 'SocialController@handleProviderCallback');



Route::get('/{slug}', 'ProfileController@index')->name('profile.index')->where('slug', '[0-9a-zA-Z-_]+');


// Route::group(['prefix' => '{user_slug}'], function() {
    //Products
    Route::get('/{user_slug}/post', 'ProductController@index')->name('product.index'); 
    Route::get('/{user_slug}/post/create', 'ProductController@create')->name('product.create');
    Route::get('/{user_slug}/post/{slug}', 'ProductController@show')->name('product.show');
    Route::post('/{user_slug}/post/store', 'ProductController@store')->name('product.store');
    Route::post('/{user_slug}/post/delete/{id}', 'ProductController@destroy')->name('product.destroy');
           
    Route::get('/{user_slug}/post/{slug}/edit', 'ProductController@edit')->name('product.edit');   
    Route::post('/{user_slug}/post/update/{slug}', 'ProductController@update')->name('product.update');
    
// });



Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');

Route::group(['prefix' => 'admin'], function() {
    Route::group(['prefix' => 'permissions'], function() {
        Route::get('/', 'PermissionController@index')->name('permission.index');
        Route::post('/', 'PermissionController@store')->name('permission.store');
    });
});

Route::get('{user_slug}/profile_edit', 'ProfileController@edit')->name('profile.edit');