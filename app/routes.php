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

Route::get('/', 'HomeController@showHome');

Route::get('init', 'InitController@doInit');

Route::controller('dashboard', 'DashboardController');

Route::controller('login', 'LoginController');

Route::controller('password', 'PasswordController');

Route::get('user/register', 'UserController@showRegister');
Route::post('user/register', 'UserController@doRegister');

