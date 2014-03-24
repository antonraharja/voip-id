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

Route::get('/', 'HomeController@showWelcome');

Route::get('dashboard', array('before' => 'auth', 'uses' => 'HomeController@showDashboard'));

Route::get('user/login', 'UserController@showLogin');

Route::get('user/register', 'UserController@showRegister');

Route::get('user/logout', 'UserController@doLogout');

Route::post('user/login', 'UserController@doLogin');

Route::post('user/register', 'UserController@doRegister');
