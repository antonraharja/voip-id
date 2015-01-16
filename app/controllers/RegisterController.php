<?php
use Aamant\EmailConfirmation;
class RegisterController extends BaseController {

	public function getIndex() {
		if(Cookie::get('domain_hash') && Domain::find(Cookie::get('domain_hash'))->allow_registration == 0){
			return Redirect::to('login');
		}else{
			return View::make('register.index');
		}
	}

	public function postIndex() {
		$input = Input::only('first_name', 'last_name', 'email', 'username', 'password','domain_id');
		$domain_id = Cookie::get('domain_hash') ? Cookie::get('domain_hash') : 'NULL';

		$rules = array(
			'first_name' => 'required|min:1',
			'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL,domain_id,'.$domain_id,
			'username' => 'required|min:3|must_alpha_num|unique:users,username,NULL,id,deleted_at,NULL,domain_id,'.$domain_id,
			'password' => 'required|min:6',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			return Output::push(array('path' => 'register', 'errors' => $v, 'input' => TRUE));
		}

		$profile = new Profile(array(
			'first_name' => $input['first_name'],
			'last_name' => $input['last_name'],
			'website' => '',
		));
		$profile->save();

		$user = new User(array(
            'domain_id' => Cookie::get('domain_hash') ? Cookie::get('domain_hash') : NULL,
			'email' => $input['email'],
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
			'status' => Cookie::get('domain_hash') ? 4 : 3,
		));
		$user->profile()->associate($profile);
		$user->save();

		if ($user->id) {
			$this->add_phone_number($user->id);
			$cookie = Cookie::forget('rndext');
			$confirmation = App::make('email-confirmation');
			$confirmation->send($user);
			Mail::send('emails.register', array('new_user' => $input['username']), function($message) {
	    			$message->from(
	    				Config::get('mail.from.address'),
	    				Config::get('mail.from.name')
	    				)
	    				->to(Input::get('email'))
	    				->subject(_('New user registration'));
			});

            Event::fire('logger',array(array('account_register', array('id'=>$user->id,'username'=>$user->username), 2)));
//			return Output::push(array(
//				'path' => 'register',
//				'messages' => array('success' => _('You have registered successfully')),
//				));
			return Redirect::to('register')->with('success', _('You have registered successfully'))->withCookie($cookie);
		} else {
			return Output::push(array(
				'path' => 'register',
				'messages' => array('fail' => _('Fail to register')),
				'input' => TRUE,
				));
		}
	}

	private function add_phone_number($uid){
		$password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
		$params = array('sip_password'=>$password, 'user_id'=>$uid, 'description'=>'default phone number');
		App::make('PhoneNumberController')->postStore($params);
	}

}
