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
			return Output::push(array('path' => 'login', 'errors' => $v));
		}

		// check login with username
		if (Auth::attempt(array('username' => $input['username'], 'password' => $input['password']), $input['remember'])) {
			//check ban status
			if (Auth::user()->flag_banned == 1){
	    			Auth::logout();
				return Output::push(array(
					'path' => 'login',
					'messages' => array('fail' => _('You are banned'))
					));
			}
            //set cookie domain hash
            if(Auth::user()->status == 4){
                Cookie::queue('domain_hash',Auth::user()->domain_id);
            }
			return Output::push(array(
				'path' => 'dashboard',
				'messages' => array('success' => _('You have successfully logged in'))
				));
		}

		// try again this time with email address as username
		if (Auth::attempt(array('email' => $input['username'], 'password' => $input['password']), $input['remember'])) {
			//check ban status
			if (Auth::user()->ban == 1){
	    			Auth::logout();
				return Output::push(array(
					'path' => 'login',
					'messages' => array('fail' => _('You are banned'))
					));
			}
            //set cookie domain hash
            if(Auth::user()->status == 4){
                Cookie::queue('domain_hash',Auth::user()->domain_id);
            }
			return Output::push(array(
				'path' => 'dashboard',
				'messages' => array('success' => _('You have successfully logged in'))
				));
		} else {
			return Output::push(array(
				'path' => 'login',
				'messages' => array('fail' => _('Invalid username or password'))
				));
		}
	}

	public function getLogout() {
		Auth::logout();
		return Output::push(array(
			'path' => 'login',
			'messages' => array('success' => _('You have been logged out'))
			));
	}

}
