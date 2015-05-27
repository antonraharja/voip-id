<?php
if (App::runningInConsole()) {
	return;
}

// WARNING: you must comment this init route on production
// INIT INIT INIT COMMENT THIS AFTER FIRST USAGE
Route::controller('init', 'InitController');

//route by domain
foreach (Domain::all() as $dcp) {
	Route::group(array(
		'domain' => $dcp['domain'] 
	), function () use($dcp) {
		if (!Cookie::get('domain_hash')) {
			Route::get('/', 'PanelController@dcp');
		}
	});
}

Route::get('/', 'HomeController@showHome');

Route::controller('login', 'LoginController');
Route::get('logout', 'LoginController@getLogout');

Route::controller('register', 'RegisterController');

Route::controller('password', 'PasswordController');

// Start of private routes protected with auth


Route::controller('dashboard', 'DashboardController');

Route::get('phone_number/manage/{hash}', 'PhoneNumberController@manage');
Route::get('phone_number/manage/{hash}/add', 'PhoneNumberController@getAdd');
Route::get('phone_number/manage/{hash}/edit/{id}', 'PhoneNumberController@getEdit');
Route::post('phone_number/manage/{hash}/store', 'PhoneNumberController@postStore');
Route::any('phone_number/manage/{hash}/update/{id}', 'PhoneNumberController@update');
Route::get('phone_number/manage/{hash}/delete/{id}', 'PhoneNumberController@getDelete');

Route::any('phone_number/update/{id}', 'PhoneNumberController@update');
Route::any('phone_number/search', 'PhoneNumberController@getIndex');
Route::controller('phone_number', 'PhoneNumberController');




Route::controller('online_phones', 'OnlinePhonesController');
Route::post('call_detail_reports/filter', 'CallDetailReportsController@getFilter');
Route::controller('call_detail_reports', 'CallDetailReportsController');

Route::any('gateway/search', 'GatewayController@getIndex');
Route::controller('gateway', 'GatewayController');

Route::resource('profile', 'ProfileController', array(
	'only' => array(
		'index',
		'update' 
	) 
));

Route::controller('token', 'TokenController');


//Route::controller('user', 'UserController');
//Route::get('user', 'UserController@getLogout');
Route::resource('user', 'UserController', array(
	'only' => array(
		'index',
		'update' 
	) 
));

Route::resource('users', 'UserManagementController', array(
	'only' => array(
		'index',
		'update',
		'delete' 
	) 
));
Route::get('users/add/{hash?}', 'UserManagementController@create');
Route::post('users/save/{hash?}', 'UserManagementController@store');
Route::get('users/edit/{id}/{hash?}', 'UserManagementController@edit');
Route::any('users/update/{id}/{hash?}', 'UserManagementController@update');
Route::get('users/delete/{id}/{hash?}', 'UserManagementController@destroy');
Route::get('users/ban/{id}/{hash?}', 'UserManagementController@ban');
Route::get('users/unban/{id}/{hash?}', 'UserManagementController@unban');

Route::get('managers', 'UserManagementController@manager');

Route::any('users/search', 'UserManagementController@index');
Route::any('managers/search', 'UserManagementController@manager');
Route::get('managers/add/{hash?}', 'UserManagementController@create');
Route::post('managers/save/{hash?}', 'UserManagementController@store');
Route::get('managers/edit/{id}/{hash?}', 'UserManagementController@edit');
Route::any('managers/update/{id}/{hash?}', 'UserManagementController@update');
Route::get('managers/delete/{id}/{hash?}', 'UserManagementController@destroy');
Route::get('managers/ban/{id}/{hash?}', 'UserManagementController@ban');
Route::get('managers/unban/{id}/{hash?}', 'UserManagementController@unban');

Route::any('domain/update/{id}', 'DomainController@update');
Route::any('domain/search', 'DomainController@getIndex');
Route::any('domain/users/{id}/search', 'DomainController@getUsers');
Route::get('domain/users/add/{id}', 'DomainController@addUser');
Route::controller('domain', 'DomainController');

Route::get(Config::get('settings.panel_path') . '/{hash}', 'PanelController@register');
Route::any(Config::get('settings.panel_path') . '/{hash}/save', 'PanelController@store');





Route::controller('main_config', 'SettingController');

Route::controller('contact', 'ContactController');
