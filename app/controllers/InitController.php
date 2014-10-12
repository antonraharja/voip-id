<?php

class InitController extends BaseController {

	public function getIndex() {

		// truncate tables and add default user 'admin'

		DB::table('users')->truncate();
		DB::table('profiles')->truncate();
		DB::table('password_resets')->truncate();

		$profile = new Profile(array(
			'first_name' => 'System',
			'last_name' => 'Administrator',
			'website' => 'https://github.com/antonraharja/laravel-startup',
		));
		$profile->save();

		$user = new User(array(
			'email' => 'admin@host.local',
			'username' => 'admin',
			'password' => Hash::make('admin123'),
			'status' => 2,
			'ban' => 0
		));
		$user->profile()->associate($profile);
		$user->save();

		// just throw something
		print_r('init done.');
	}

}
