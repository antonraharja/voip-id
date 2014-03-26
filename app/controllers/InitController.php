<?php

class InitController extends BaseController {

	public function getIndex() {

		// truncate tables and add default user 'admin'

		DB::table('users')->truncate();
		DB::table('profiles')->truncate();
		DB::table('password_reminders')->truncate();

		$profile = new Profile(array(
			'name' => 'Administrator',
		));
		$profile->save();

		$user = new User(array(
			'email' => 'admin@host.local',
			'username' => 'admin',
			'password' => Hash::make('admin123'),
		));
		$user->profile()->associate($profile);
		$user->save();

		// just throw something
		print_r('init done.');
	}

}
