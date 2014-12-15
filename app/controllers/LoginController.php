<?php

class LoginController extends BaseController {

	public function getIndex() {
        $success = Session::get('success');
        if($success == 'email-confirmation::messages.confirmed' || $success == 'Your email is confirmed'){
            Event::fire('logger',array(array('email_confirmation','',2)));
        }

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
			if(!$this->_checkDcp()) {
				Auth::logout();
				return Output::push(array(
					'path' => 'login',
					'messages' => array('fail' => _('You are not allowed login from this site'))
				));
			}
			$cookie = $this->_setCookie();

			return Redirect::to('dashboard')->with('success', _('You have successfully logged in'))->withCookie($cookie);
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
			$cookie = $this->_setCookie();

            return Redirect::to('dashboard')->with('success', _('You have successfully logged in'))->withCookie($cookie);
		} else {
            Event::fire('logger', array(array('login_failed',array('username'=>$input['username']),3)));
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


	private function _setCookie(){
		if(Auth::user()->status == 4){
			$cookie = Cookie::make('domain_hash',Auth::user()->domain_id);
		}else{
			$cookie = Cookie::forget('domain_hash');
		}

		return $cookie;
	}

	private function _checkDcp(){
		$ret = TRUE;
		if(Auth::user()->status == 4) {
			if (Auth::user()->domain->domain != Request::getHttpHost()) {
				$ret = FALSE;
			}
		}elseif(Auth::user()->status == 3){
			$domain = array('teleponrakyat.id');
			foreach (Domain::whereUserId(Auth::user()->id)->get() as $row) {
				$domain[] = $row->domain;
			}
			if(!in_array(Request::getHttpHost(), $domain)) {
				$ret = FALSE;
			}
		}

		return $ret;

	}
}
