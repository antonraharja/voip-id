<?php

class LoginController extends BaseController {

	public function getIndex() {
		return View::make('login.index');
	}

	public function postIndex() {
		$input = Input::only('username', 'password', 'remember');

		$rules = array(
			'username' => 'required|min:3',
			'password'  => 'required|min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Redirect::to('login')->withErrors($v);
		}

		// check login with username
		if (Auth::attempt(array('username' => $input['username'], 'password' => $input['password']), $input['remember'])) {
			return Redirect::to('dashboard')->with('success', _('You have successfully logged in'));
		}

		// try again this time with email address as username
		if (Auth::attempt(array('email' => $input['username'], 'password' => $input['password']), $input['remember'])) {
			return Redirect::to('dashboard')->with('success', _('You have successfully logged in'));
		} else {
			return Redirect::to('login')->with('fail', _('Invalid username or password'));
		}
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::to('login')->with('success', _('You have been logged out'));
	}

}
