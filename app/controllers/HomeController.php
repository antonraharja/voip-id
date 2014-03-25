<?php

class HomeController extends BaseController {

	public function showHome() {

		// begin init
		$profile = new Profile(array(
			'name' => 'Administrator',
			'email' => 'admin@host.local',
		));
		$profile->save();

		$user = new User(array(
			'username' => 'admin',
			'password' => Hash::make('admin'),
		));
		$user->profile()->associate($profile);
		$user->save();
		// end init

		return View::make('home');
	}

}
