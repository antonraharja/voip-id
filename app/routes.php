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
