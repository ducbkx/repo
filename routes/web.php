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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('change_password', 'Auth\ChangePasswordController@showForm')->name('users.change_password');
Route::post('change_password', 'Auth\ChangePasswordController@postChange')->name('users.password.postChange');

Route::group(['middleware' => 'admin'], function() {
    Route::get('create', 'UserController@create');
    Route::post('create', 'UserController@store')->name('users.create');

    Route::get('user', 'UserController@index')->name('user.index');

    Route::get('user/{id}/edit', 'UserController@edit')->name('user.edit');
    Route::post('user/{id}/update', 'UserController@update')->name('user.update');
    Route::get('user/{id}/delete', 'UserController@destroy')->name('user.destroy');
    Route::get('user/{id}/reset', 'UserController@resetPassword')->name('user.reset');

    Route::get('createdivision', 'DivisionController@create');
    Route::post('createdivision', 'DivisionController@store')->name('division.create');

    Route::get('division', 'DivisionController@showDivision')->name('showDivision');

    Route::get('division/{id}/edit', 'DivisionController@edit');
    Route::post('division/{id}/update', 'DivisionController@update')->name('division.update');
    Route::get('division/{id}/delete', 'DivisionController@destroy');
});

Route::group(['middleware' => 'role'], function() {
    Route::get('employee', 'UserController@showEmployee')->name('user.employee');
    Route::get('excel', 'UserController@excel')->name('excel');
});

Route::group(['middleware' => 'login'], function() {
    Route::get('information', 'UserController@information')->name('information');
    Route::get('information/{id}/edit', 'UserController@editInformation');
    Route::post('information/{id}/update', 'UserController@updateInformation')->name('information.update');
});


