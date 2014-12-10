<?php
class InitController extends BaseController {

	public function getIndex() {
		
		// truncate tables and add default user 'admin'
		DB::table('users')->truncate();
		DB::table('profiles')->truncate();
		DB::table('password_resets')->truncate();
		DB::table('settings')->truncate();
		DB::table('domains')->truncate();
		DB::table('phone_numbers')->truncate();
		DB::table('logs')->truncate();
		
		$profile = new Profile(array(
			'first_name' => 'System',
			'last_name' => 'Administrator',
			'website' => 'https://github.com/antonraharja/laravel-startup' 
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
		
		$settings = array(
			array(
				'name' => 'global_prefix',
				'value' => '62520' 
			),
			array(
				'name' => 'panel_path',
				'value' => 'dcp' 
			),
			array(
				'name' => 'domain_limit',
				'value' => '1' 
			),
			array(
				'name' => 'phone_number_limit',
				'value' => '1' 
			),
			array(
				'name' => 'email_address_for_notification',
				'value' => 'noreply@teleponrakyat.id' 
			),
			array(
				'name' => 'email_address_for_admin',
				'value' => 'noreply@teleponrakyat.id' 
			),
			array(
				'name' => 'sender_name',
				'value' => 'Telepon Rakyat' 
			),
			array(
				'name' => 'sip_server',
				'value' => 'sip.teleponrakyat.id' 
			),
			array(
				'name' => 'reserved_extension',
				'value' => '100000, 200000, 300000, 400000, 500000, 600000, 700000, 800000, 900000, 111111, 222222, 333333, 444444, 555555, 666666, 777777, 888888, 999999, 123456, 654321' 
			),
			array(
				'name' => 'reserved_domain_prefix',
				'value' => '100, 200, 300, 400, 500, 600, 700, 800, 900, 111, 222, 333, 444, 555, 666, 777, 888, 999, 123, 456, 789, 987, 654, 321' 
			),
			array(
				'name' => 'log_file',
				'value' => '/tmp/teleponrakyatid.log' 
			),
			array(
				'name' => 'available_css',
				'value' => 'default, flatly, united, lumen, yeti, paper, cerulean, cyborg, darkly, journal, readable, sandstone, simplex, slate, spacelab, superhero' 
			) 
		);
		
		foreach ($settings as $setting) {
			Setting::create($setting);
		}
		
		// just throw something
		print_r('init done.');
	}
}
