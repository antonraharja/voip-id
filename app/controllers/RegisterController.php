<?php

class RegisterController extends BaseController {

	public function getIndex() {
		return View::make('register.index');
	}

	public function postIndex() {
		$input = Input::only('name', 'email', 'username', 'password','password_confirmation');

		$rules = array(
			'name' => 'required|min:3',
			'email' => 'required|email|unique:users',
			'username' => 'required|min:3|alpha_num|unique:users',
			'password' => 'required|min:6|confirmed',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Redirect::to('register')->withErrors($v)->withInput();
		}

		$profile = new Profile(array(
			'name' => $input['name'],
		));
		$profile->save();

		$user = new User(array(
			'email' => $input['email'],
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
		));
		$user->profile()->associate($profile);
		$user->save();

		if ($user->id) {
			return Redirect::to('register')->with('success', _('You have registered successfully'));
		} else {
			return Redirect::to('register')->with('fail', _('Fail to register'));
		}
	}

}
