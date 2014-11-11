<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
	if(Cookie::get('domain_hash')){
        $domain = Domain::find(Cookie::get('domain_hash'));
        if(!$domain){
            Auth::logout();
            $cookie = Cookie::forget('domain_hash');
            return Redirect::guest('login')->withCookie($cookie);
        }
    }
});


App::after(function($request, $response) {
	//
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
	if (Auth::guest())
		return Redirect::guest('login');
});


Route::filter('auth.basic', function() {
	return Auth::basic();
});

Route::filter('auth.admin', function() {
  if (Auth::user()->status != 2)
    return Redirect::to('dashboard');
});

Route::filter('auth.manager', function() {
    if(Request::segment(4) && Request::segment(4)!='search'){
        if(Auth::user()->status != 2) {
            $domain = Domain::find(Request::segment(4))->where('user_id', Auth::user()->id)->get();
            if (count($domain) <= 0) {
                return Redirect::to('dashboard');
            }
        }
    }
    if (Auth::user()->status != 3 && Auth::user()->status != 2 )
        return Redirect::to('dashboard');
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
	if (Auth::check())
		return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
	if (Session::token() !== Input::get('_token')) {
		throw new Illuminate\Session\TokenMismatchException;
	}
});
