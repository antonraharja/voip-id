<?php
use Aamant\EmailConfirmation;
class RegisterController extends BaseController {

	public function getIndex() {
		return View::make('register.index');
	}

	public function postIndex() {
		$input = Input::only('first_name', 'last_name', 'email', 'username', 'password','domain_id');

		$rules = array(
			'first_name' => 'required|min:1',
			'email' => 'required|email|unique:users',
			'username' => 'required|min:3|alpha_num|unique:users',
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
			$confirmation = App::make('email-confirmation');
			$confirmation->send($user);
			Mail::send('emails.register', array('new_user' => $input['username']), function($message) {
	    			$message->from(
	    				Config::get('startup.email_sender.address'),
	    				Config::get('startup.email_sender.name')
	    				)
	    				->to(Input::get('email'))
	    				->subject(_('New user registration'));
			});

			return Output::push(array(
				'path' => 'register',
				'messages' => array('success' => _('You have registered successfully')),
				));
		} else {
			return Output::push(array(
				'path' => 'register',
				'messages' => array('fail' => _('Fail to register')),
				'input' => TRUE,
				));
		}
	}

}
