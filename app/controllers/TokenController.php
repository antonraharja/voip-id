<?php

class TokenController extends BaseController {

	public function getIndex(){
		if(Request::segment(2)=='search'){
            $input = Session::get('search') && !Input::get('search_category') ? Session::get('search') : Input::only(array('search_category','search_keyword'));
            switch($input['search_category']){
                case '0':
                    return Redirect::to('domain');
                    break;

                case 'owner':
                    $domains = Domain::whereHas('user', function($q){
                        $q->where('username', 'LIKE', '%'.Input::get('search_keyword').'%');
                    })->get();
                    break;

                default:
                    if(Auth::user()->status == 2) {
                        $domains = Domain::where($input['search_category'], 'LIKE', '%' . $input['search_keyword'] . '%')->get();
                    }else{
                        $domains = Domain::where('user_id', Auth::user()->id)->where($input['search_category'], 'LIKE', '%' . $input['search_keyword'] . '%')->get();
                    }
                    break;
            }
            Session::set('search', $input);
        }else {
            Session::remove('search');
            $input = array('search_category'=>'','search_keyword'=>'');
            $domains = Auth::user()->status == 2 ? Domain::all() : Domain::where('user_id', Auth::user()->id)->get();
        }

        return View::make('token.index')->with('domains', $domains)->with('selected', $input);
	}
	
	public function getAdd()
	{
        $token = new Token;
        $token->token = Hash::make('koplok');
        $token->user_id = Auth::user()->id;
        $token->save();
        return Output::push(array(
							'path' => 'token',
							'messages' => array('success' => _('Token was created')),
							));
        
        
	}
	public function postIndex()
	{
        $token = new Token;
        $token->token = Hash::make('koplok');
        $token->user_id = Auth::user()->id;
        $token->save();
        return Output::push(array(
							'path' => 'token',
							'messages' => array('success' => _('Token was created')),
							));
        
        
	}
	
	
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
		
	}
	
	private function _checkDcp($email){
		$ret = TRUE;
		$results = DB::select('select users.id,status,domain from users,domains where users.domain_id = domains.id and domains.deleted_at is NULL and users.email = ?', array($email));
		$results4admin = DB::select('select users.id,status from users where domain_id is NULL and deleted_at is NULL and users.email = ?', array($email));
		if($results && !$results4admin){
			if($results[0]->status == 4) {
				if ($results[0]->domain != Request::getHttpHost()) {
					$ret = FALSE;
				}
			}elseif($results[0]->status == 3) {
				/* fixme anton
				$domain = array('localhost','localhost:8000','local.teleponrakyat.id','local.teleponrakyat.id:8000','teleponrakyat.id','www.teleponrakyat.id');
				foreach ($results as $row) {
					$domain[] = $row->domain;
				}
				if(!in_array(Request::getHttpHost(), $domain)) {
					$ret = FALSE;
				}else{
					$ret = FALSE;
				}
				*/
				$ret = TRUE;
			}
		}elseif($results4admin) {
			$ret = TRUE;
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
