<?php

class PasswordController extends BaseController {

	public function getRecovery() {
		return View::make('password.recovery');
	}

	public function postRecovery() {
		$input = Input::only('email');
		
		if(!$this->_checkDcp($input['email'])){
		return Output::push(array(
					'path' => 'password/recovery',
					'messages' => array('fail' => _('User is not in this domain')),
					));
		}else{
				switch ($response = Password::remind($input, function($message){
		            $message->subject('Password Reset');
		        })) {
					case Password::INVALID_USER:
						return Output::push(array(
							'path' => 'password/recovery',
							'messages' => array('fail' => _('Unable to find user')),
							));
		
					case Password::REMINDER_SENT:
						return Output::push(array(
							'path' => 'password/recovery',
							'messages' => array('success' => _('Password recovery request has been sent to email')),
							));
				}
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
			'email', 'password', 'token'
		);

        //hack password_confirmation for package
        $credentials['password_confirmation'] = $credentials['password'];

		$rules = array(
			'email' => 'required|email',
			'password' => 'required|min:6',
			'token' => 'required',
		);
		$v = Validator::make($credentials, $rules);
		if ($v->fails()) {
			return Output::push(array(
				'path' => 'password/reset',
				'errors' => $v,
				'input' => TRUE,
				));
		}
		
		//new style
		$validtoken = $this->_isValidToken($credentials['email'],$credentials['token']);
		if ($validtoken) {
			$id = $this->_getUserId($credentials['email']);
			if($id){
				$user = user::find($id);
				//$user->username = $input['username'];
				$user->email = $credentials['email']; 
				if ($credentials['password']) {
					$user->password = Hash::make($credentials['password']);
	                Event::fire('logger',array(array('account_password_update', array('id'=>$id,'username'=>$user->username), 2)));
				}
				$user->save();
	
				return Output::push(array(
						'path' => 'login',
						'messages' => array('success' => _('Password has been reset')),
						));
			}else{
				return Output::push(array(
					'path' => 'password/recovery',
					'messages' => array('fail' => _('Unable to process password reset')),
					));
			}
		} else {
			return Output::push(array(
					'path' => 'password/recovery',
					'messages' => array('fail' => _('Invalid token')),
					));
		}
		
		
		
		/*
		//old style erro
		$response = Password::reset($credentials, function($user, $email,$password) {
			$id = $this->_getUserId($email);
			$user = user::find($id);
			$user->password = Hash::make($password);
			$user->save();
		});

		switch ($response) {
			case Password::INVALID_PASSWORD:
			case Password::INVALID_USER:
				return Output::push(array(
					'path' => 'password/recovery',
					'messages' => array('fail' => _('Unable to process password reset')),
					));

			case Password::INVALID_TOKEN:
				return Output::push(array(
					'path' => 'password/recovery',
					'messages' => array('fail' => _('Invalid token')),
					));

			case Password::PASSWORD_RESET:
				return Output::push(array(
					'path' => 'login',
					'messages' => array('success' => _('Password has been reset')),
					));
		}
		*/
	}
	
	private function _checkDcp($email){
		$ret = TRUE;
		$results = DB::select('select users.id,status,domain from users,domains where users.domain_id = domains.id and domains.deleted_at is NULL and users.email = ?', array($email));
		if($results){
			if($results[0]->status == 4) {
				if ($results[0]->domain != Request::getHttpHost()) {
					$ret = FALSE;
				}
			}elseif($results[0]->status == 3) {
				$domain = array('localhost','localhost:8000','local.teleponrakyat.id','local.teleponrakyat.id:8000','teleponrakyat.id','www.teleponrakyat.id');
				foreach ($results as $row) {
					$domain[] = $row->domain;
				}
				if(!in_array(Request::getHttpHost(), $domain)) {
					$ret = FALSE;
				}else{
					$ret = FALSE;
				}
			}
		}else $ret=FALSE;
		
		return $ret;	
	}
	
	private function _getUserId($email){
		$domain = Domain::where('domain', Request::getHttpHost())->first();
		$user = User::where('email', $email)->where('domain_id', $domain['id'])->first();
		return $user['id'];	
	}
	
	private function _isValidToken($email,$token){
		$results = DB::select("select curtime()-time(created_at) as created_at from password_resets where date(created_at) = date(now()) and email = ? and token = ?", array($email,$token));
		if($results[0]->created_at <= 10000){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
}
