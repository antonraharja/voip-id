<?php

class InitController extends BaseController {

	public function getIndex() {

		// truncate tables and add default user 'admin'

		DB::table('users')->truncate();
		DB::table('profiles')->truncate();
		DB::table('password_resets')->truncate();
        DB::table('settings')->truncate();

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
                'value' => '123,999,888,777,666,555,444,333,222,111,100,200,300,400,500,600,700,800,900,456,678,789,707',
            ),
            array(
                'name' => 'reserved_domain_prefix',
                'value' => '123,999,888,777,666,555,444,333,222,111,100,200,300,400,500,600,700,800,900,456,678,789,707',
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
