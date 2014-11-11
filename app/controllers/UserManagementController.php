<?php

class UserManagementController extends BaseController {


	/**
	 * Instantiate a new UserManagementController instance.
	 */
	public function __construct() {

		$this->beforeFilter('auth');
        if(Request::segment(4) || (strpos(Route::currentRouteAction(),'create') && Request::segment(3)) || (strpos(Route::currentRouteAction(),'store') && Request::segment(3))){
            $this->beforeFilter('auth.manager');
        }else{
            $this->beforeFilter('auth.admin');
        }

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if(Request::segment(2)=='search'){
            $input = Session::get('search') && !Input::get('search_category') ? Session::get('search') : Input::only(array('search_category','search_keyword'));
            switch($input['search_category']){
                case '0':
                    return Redirect::to('users');
                    break;

                case 'owner':
                    $users = User::where('status',4)->whereHas('domain', function($q){
                        $q->whereHas('user', function($q){
                            $q->where('username', 'like', '%'.Input::get('search_keyword').'%');
                        });
                    })->get();
                    break;

                case 'name':
                    $users = User::where('status',4)->whereHas('profile', function($q){
                        $q->where(function($q){
                            $q->where('first_name', 'like', '%'.Input::get('search_keyword').'%');
                            $q->orWhere('last_name', 'like', '%'.Input::get('search_keyword').'%');
                        });
                    })->get();
                    break;

                default:
                    $users = User::where('status',4)->where($input['search_category'], 'LIKE', '%'.$input['search_keyword'].'%')->get();
                    break;
            }
            Session::set('search', $input);
        }else{
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $users = User::where('status',4)->get();
        }
        
		return View::make('user_management.index')->with('users', $users)->with('selected', $input);
	}

    public function manager()
    {
        if(Request::segment(2)=='search'){
            $input = Session::get('search') && !Input::get('search_category') ? Session::get('search') : Input::only(array('search_category','search_keyword'));
            switch($input['search_category']){
                case '0':
                    return Redirect::to('managers');
                    break;

                case 'owner':
                    $users = User::where('status',3)->whereHas('domain', function($q){
                        $q->whereHas('user', function($q){
                            $q->where('username', 'like', '%'.Input::get('search_keyword').'%');
                        });
                    })->get();
                    break;

                case 'name':
                    $users = User::where('status',3)->whereHas('profile', function($q){
                        $q->where(function($q){
                            $q->where('first_name', 'like', '%'.Input::get('search_keyword').'%');
                            $q->orWhere('last_name', 'like', '%'.Input::get('search_keyword').'%');
                        });
                    })->get();
                    break;

                default:
                    $users = User::where('status',3)->where($input['search_category'], 'LIKE', '%'.$input['search_keyword'].'%')->get();
                    break;
            }
            Session::set('search', $input);
        }else {
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $users = User::where('status', 3)->get();
        }

        return View::make('user_management.index')->with('users', $users)->with('selected',$input);
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

		$input = Input::only('first_name', 'last_name', 'website', 'email', 'username', 'password', 'status', 'domain_id');

        $domain_id = Request::segment(3) ? Request::segment(3) : NULL;

		$rules = array(
			'first_name' => 'required|min:1',
			'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
			'username' => 'required|min:3|must_alpha_num|unique:users,username,NULL,id,deleted_at,NULL',
			'password' => 'required|min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array('path' => 'users/add', 'errors' => $v, 'input' => TRUE));
		}

		$profile = new Profile(array(
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
			'website' => $input['website'],
		));
		$profile->save();

		$user = new User(array(
            'domain_id' => $domain_id,
			'email' => $input['email'],
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
			'status' => $input['status'],
		));
		$user->profile()->associate($profile);
		$user->save();

        $path = Request::segment(3) ? 'domain/users/'.Request::segment(3) : 'users';

		if ($user->id) {
            Event::fire('logger',array(array('account_add', array('id'=>$user->id,'username'=>$user->username), 2)));
			return Output::push(array(
				'path' => $path,
				'messages' => array('success' => _('You have added user successfully')),
				));
		} else {
			return Output::push(array(
				'path' => 'users',
				'messages' => array('fail' => _('Fail to add user')),
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

        $path = Request::segment(4) ? 'domain/users/'.Request::segment(4) : 'users';

		return Output::push(array(
				'path' => $path,
				'messages' => array('success' => _('User has been banned')),
				));
	}

	public function unban($id)
	{
		$user = user::find($id); 
		$user->flag_banned = 0;
		$user->save();

        $path = Request::segment(4) ? 'domain/users/'.Request::segment(4) : 'users';

		return Output::push(array(
				'path' => $path,
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
		$input = Input::only('first_name', 'last_name', 'email', 'website', 'username', 'password');

		$rules = array(
			'first_name' => 'required|min:1',
			'email' => 'required|email|unique:users,email,'.$id.',id,deleted_at,NULL',
//			'username' => 'required|min:3|alpha_num|unique:users,username,'.$id.',id,deleted_at,NULL',
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
		//$user->username = $input['username'];
		$user->email = $input['email'];
		if ($input['password']) {
			$user->password = Hash::make($input['password']);
            Event::fire('logger',array(array('account_password_update', array('id'=>$id,'username'=>$user->username), 2)));
		}

		$user->profile()->associate($profile);
		$user->save();

        $path = Request::segment(4) ? 'domain/users/'.Request::segment(4) : 'users';

		if ($id) {
			return Output::push(array(
				'path' => $path,
				'messages' => array('success' => _('You have updated user successfully')),
				));
		} else {
			return Output::push(array(
				'path' => 'users/edit/'.$id,
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
        $user = User::find($id);
        $profile = Profile::find($user->profile_id);
        $user->delete();
        $profile->delete();
        if($user->domain_id == NULL) {
            $domain = Domain::whereUserId($id)->first();
            $domain->delete();
        }
        $subuser = User::whereDomainId($domain->id)->first();
        $subuser->delete();
        PhoneNumber::whereUserId($subuser->id)->delete();

        Event::fire('logger',array(array('account_remove', array('id'=>$id,'username'=>$user->username), 2)));

        $path = Request::segment(4) ? 'domain/users/'.Request::segment(4) : 'users';
        $path = $user->domain_id ? $path : "managers";

		return Output::push(array(
			'path' => $path,
			'messages' => array('success' => _('User has been deleted'))
			));
	}


}
