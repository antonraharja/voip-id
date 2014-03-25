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
		$input = Input::only('username', 'password', 'remember');

		$rules = array(
			'username' => 'required|min:3',
			'password'  => 'required|min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Redirect::to('user/login')->withErrors($v);
		}

		if (Auth::attempt(array('username' => $input['username'], 'password' => $input['password']), $input['remember'])) {
			return Redirect::to('dashboard')->with('success', _('You have successfully logged in'));
		} else {
			return Redirect::to('user/login')->with('fail', _('Invalid username or password'));
		}
	}

	public function doRegister() {
		$input = Input::only('name', 'email', 'username', 'password','password_confirmation');

		$rules = array(
			'name' => 'required|min:3',
			'email' => 'required|email|unique:profiles',
			'username' => 'required|min:3|alpha_num|unique:users',
			'password' => 'required|min:6|confirmed',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Redirect::to('user/register')->withErrors($v)->withInput();
		}

		$profile = new Profile(array(
			'name' => $input['name'],
			'email' => $input['email'],
		));
		$profile->save();

		$user = new User(array(
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
		));
		$user->profile()->associate($profile);
		$user->save();

		if ($user->id) {
			return Redirect::to('user/register')->with('success', _('You have registered successfully'));
		} else {
			return Redirect::to('user/register')->with('fail', _('Fail to register'));
		}
	}

}
