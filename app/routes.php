<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */


// WARNING: you must comment this init route on production
Route::controller('init', 'InitController');


// Start of public routes

Route::get('/', 'HomeController@showHome');

Route::controller('login', 'LoginController');
Route::get('logout', 'LoginController@getLogout');

Route::controller('register', 'RegisterController');

Route::controller('password', 'PasswordController');


// Start of private routes protected with auth

Route::controller('dashboard', 'DashboardController');

Route::resource('profile', 'ProfileController', array('only' => array('index', 'update')));

Route::resource('user', 'UserController', array('only' => array('index', 'update')));

Route::resource('users', 'UserManagementController',  array('only' => array('index', 'update','delete')));
Route::get('users/create', 'UserManagementController@create');
Route::post('users/save', 'UserManagementController@store');
Route::get('users/edit/{id}', 'UserManagementController@edit');
Route::any('users/update/{id}', 'UserManagementController@update');
Route::get('users/delete/{id}', 'UserManagementController@destroy');
Route::get('users/ban/{id}', 'UserManagementController@ban');
Route::get('users/unban/{id}', 'UserManagementController@unban');

Route::controller('domain','DomainController');
