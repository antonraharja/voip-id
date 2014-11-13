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

        $settings = array(
            array(
                'name' => 'global_prefix',
                'value' => '62567',
            ),
            array(
                'name' => 'panel_path',
                'value' => 'dcp',
            ),
            array(
                'name' => 'domain_limit',
                'value' => '1',
            ),
            array(
                'name' => 'phone_number_limit',
                'value' => '1',
            ),
            array(
                'name' => 'mail_address',
                'value' => 'noreply@e164.or.id',
            ),
            array(
                'name' => 'sender_name',
                'value' => 'VoIP ID',
            ),
            array(
                'name' => 'sip_server',
                'value' => '202.153.137.101',
            ),
            array(
                'name' => 'reserved_extension',
                'value' => '100000, 200000, 300000, 400000, 500000, 600000, 700000, 800000, 900000, 111111, 222222, 333333, 444444, 555555, 666666, 777777, 888888, 999999, 123456, 654321',
            ),
            array(
                'name' => 'reserved_domain_prefix',
                'value' => '100000, 200000, 300000, 400000, 500000, 600000, 700000, 800000, 900000, 111111, 222222, 333333, 444444, 555555, 666666, 777777, 888888, 999999, 123456, 654321',
            ),
            array(
                'name' => 'log_file',
                'value' => '/var/log/voipid.log'
            )
        );

        foreach($settings as $setting){
            Setting::create($setting);
        }

		// just throw something
		print_r('init done.');
	}

}
