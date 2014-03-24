<?php

class UserController extends BaseController {

	public function showLogin() {
		return View::make('user.login');
	}

	public function showRegister() {
		return View::make('user.register');
	}

	public function doLogout() {
		Auth::logout();
		return Redirect::to('user/login')->with('success', _('You have been logged out'));
	}

	public function doLogin() {
		$input = Input::only('username', 'password');
		if (Auth::attempt(array('username' => $input['username'], 'password' => $input['password']))) {
			return Redirect::intended('dashboard');
		} else {
			return Redirect::to('user/login')->with('error', _('Invalid username or password'));
		}
	}

	public function doRegister() {
		//
	}

}
