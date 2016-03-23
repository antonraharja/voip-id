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
		$status = Auth::user()->status;
		if($status == 4){
		$input = Input::only('email', 'im_username','im_password','username', 'password');

		$rules = array(
			'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id,deleted_at,NULL,status,'.Auth::user()->status.'',
//			'username' => 'required|min:3|alpha_num|unique:users,username,'.Auth::user()->id.',id,deleted_at,NULL'
			'im_username' => 'required|min:3|unique:users,im_username',
			'password' => 'required|min:6',
			'im_password' => 'required|min:6',
		);
		}else{
		$input = Input::only('email','username', 'password');

		$rules = array(
			'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id,deleted_at,NULL,status,'.Auth::user()->status.'',
//			'username' => 'required|min:3|alpha_num|unique:users,username,'.Auth::user()->id.',id,deleted_at,NULL'
//			'im_username' => 'required|min:3|unique:users,im_username',
			'password' => 'required|min:6',
//			'im_password' => 'required|min:6',
		);	
		}
		/*
		if ($input['password']) {
			$rules['password'] = 'required|min:6';
		}*/
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array(
			'path' => 'user',
			'errors' => $v,
			'input' => TRUE
			));
		}

		if ($id && Auth::user()->id == $id) {
			$user = user::find($id);
			//$user->username = $input['username'];
			$user->email = $input['email']; 
			if ($input['password']) {
				$user->password = Hash::make($input['password']);		
                Event::fire('logger',array(array('account_password_update', array('id'=>$id,'username'=>$user->username), 2)));
			}
			if (array_key_exists('im_username', $input) && array_key_exists('im_password', $input)){
				$user->im_username = $input['im_username'] ;
				$user->im_password = Hash::make($input['im_password']);
				Event::fire('logger',array(array('im_account_password_update', array('id'=>$id,'username'=>$user->username), 2)));
			}
			
			$user->save();

			return Output::push(array(
				'path' => 'user',
				'errors' => 'Change Account Data Successfully',
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
