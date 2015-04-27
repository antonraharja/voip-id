<?php

class UserController extends BaseController {

	/**
	 * Instantiate a new DashboardController instance.
	 */
	public function __construct() {

		$this->beforeFilter('auth');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

		$user = user::find(Auth::user()->id);

		return View::make('user.index')->with('user', $user);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {

		$input = Input::only('email', 'username', 'password');

		$rules = array(
			'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id,deleted_at,NULL,status,'.Auth::user()->status.'',
//			'username' => 'required|min:3|alpha_num|unique:users,username,'.Auth::user()->id.',id,deleted_at,NULL'
		);
		if ($input['password']) {
			$rules['password'] = 'required|min:6';
		}
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array(
			'path' => 'user',
			'errors' => $v,
			'input' => TRUE
			));
		}

		if ($input['password'] && $id && Auth::user()->id == $id) {
			$user = user::find($id);
			//$user->username = $input['username'];
			$user->email = $input['email']; 
			if ($input['password']) {
				$user->password = Hash::make($input['password']);
                Event::fire('logger',array(array('account_password_update', array('id'=>$id,'username'=>$user->username), 2)));
			}
			$user->save();

			return Output::push(array(
				'path' => 'user',
				'errors' => 'Change Password Successfully',
				'messages' => array('success', _('User data has been saved')),
				'input' => TRUE
				));
		} else {
			return Output::push(array(
				'path' => 'user',
				'errors' => 'Unable to update user',
				'messages' => array('fail', _('Unable to update user')),
				'input' => TRUE
				));
		}

	}

}
