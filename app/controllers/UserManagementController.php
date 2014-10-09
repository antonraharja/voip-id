<?php

class UserManagementController extends BaseController {


	/**
	 * Instantiate a new UserManagementController instance.
	 */
	public function __construct() {

		$this->beforeFilter('auth');
		$this->beforeFilter('auth.admin');

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();

		return View::make('user_management.index')->with('users', $users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('user_management.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('first_name', 'last_name', 'email', 'username', 'password', 'status');

		$rules = array(
			'first_name' => 'required|min:1',
			'email' => 'required|email|unique:users',
			'username' => 'required|min:3|alpha_num|unique:users',
			'password' => 'required|min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array('path' => 'users/create', 'errors' => $v, 'input' => TRUE));
		}

		$profile = new Profile(array(
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
		));
		$profile->save();

		$user = new User(array(
			'email' => $input['email'],
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
			'status' => $input['status'],
		));
		$user->profile()->associate($profile);
		$user->save();

		if ($user->id) {
			return Output::push(array(
				'path' => 'users',
				'messages' => array('success' => _('You have created user successfully')),
				));
		} else {
			return Output::push(array(
				'path' => 'users/create',
				'messages' => array('fail' => _('Fail to create user')),
				'input' => TRUE,
				));
		}
	}


	/**
	 * Ban user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function ban($id)
	{
		$user = user::find($id); 
		$user->flag_banned = 1;
		$user->save();

		return Output::push(array(
				'path' => 'users',
				'messages' => array('success' => _('User has been banned')),
				));
	}

	public function unban($id)
	{
		$user = user::find($id); 
		$user->flag_banned = 0;
		$user->save();

		return Output::push(array(
				'path' => 'users',
				'messages' => array('success' => _('User has been unbanned')),
				));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = user::find($id);

		return View::make('user_management.edit')->with('user', $user);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::only('first_name', 'last_name', 'email', 'website', 'username', 'password','status');

		$rules = array(
			'first_name' => 'required|min:1',
			'email' => 'required|email|unique:users,email,'.$id,
			'username' => 'required|min:3|alpha_num|unique:users,email,'.$id,
			'password' => 'min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array('path' => 'users/edit/'.$id, 'errors' => $v, 'input' => TRUE));
		}

		$profile = Profile::find($id);
		$profile->first_name = $input['first_name']; 
		$profile->last_name = $input['last_name']; 
		$profile->website = $input['website']; 
		$profile->save();

		$user = user::find($id);
		$user->username = $input['username']; 
		$user->email = $input['email']; 
		$user->status = $input['status']; 
		if ($input['password']) {
			$user->password = Hash::make($input['password']);
		}

		$user->profile()->associate($profile);
		$user->save();

		if ($id) {
			return Output::push(array(
				'path' => 'users',
				'messages' => array('success' => _('You have updated user successfully')),
				));
		} else {
			return Output::push(array(
				'path' => 'users/edit'.$id,
				'messages' => array('fail' => _('Fail to update user')),
				'input' => TRUE,
				));
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);

		return Output::push(array(
			'path' => 'users',
			'messages' => array('success' => _('User has been deleted'))
			));
	}


}
