<?php

class PasswordController extends BaseController {

	public function getRecovery() {
		return View::make('password.recovery');
	}

	public function postRecovery() {
		$input = Input::only('email');

		switch ($response = Password::remind($input)) {
			case Password::INVALID_USER:
				return Redirect::to('password/recovery')->with('error', _('Unable to find user'));

			case Password::REMINDER_SENT:
				return Redirect::to('password/recovery')->with('success', _('Password recovery request has been sent to email'));
		}
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null) {
		return View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset() {
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$rules = array(
			'email' => 'required|email',
			'password' => 'required|min:6|confirmed',
			'token' => 'required',
		);
		$v = Validator::make($credentials, $rules);
		if ($v->fails()) {
			return Redirect::to('password/reset')->withErrors($v)->withInput();
		}

		$response = Password::reset($credentials, function($user, $password) {
			$user->password = Hash::make($password);
			$user->save();
		});

		switch ($response) {
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::to('password/recovery')->with('error', _('Unable to process password reset'));

			case Password::PASSWORD_RESET:
				return Redirect::to('login')->with('success', _('Password has been reset'));
		}
	}

}
