<?php

class InitController extends BaseController {

	public function doInit() {

		// truncate tables and add default user 'admin'

		DB::table('users')->truncate();
		DB::table('profiles')->truncate();

		$profile = new Profile(array(
			'name' => 'Administrator',
			'email' => 'admin@host.local',
		));
		$profile->save();

		$user = new User(array(
			'username' => 'admin',
			'password' => Hash::make('admin123'),
		));
		$user->profile()->associate($profile);
		$user->save();

		// just throw something
		print_r('init done.');
	}

}
