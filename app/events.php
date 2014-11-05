<?php
/**
 * Created by PhpStorm.
 * User: rahman
 * Date: 11/5/14
 * Time: 8:47 AM
 */

Event::listen('auth.login', function($user)
{
    Event::fire('logger', array(array('login',array('username'=>$user->username),3)));
});

Event::listen('auth.logout', function($user)
{
    $username = $user ? $user->username : '-';
    Event::fire('logger', array(array('logout',array('username'=>$username),3)));
});


Event::listen('logger', function($log)
{
    $log = array(
        'event_name'=> $log[0],
        'custom_parameter'=> json_encode($log[1]),
        'verbose_level' => $log[2],
        'ip_address' => Request::getClientIp(),
        'request_uri' => Request::url(),
    );

    $logger = Logger::create($log);

    $freshTimestamp = new \Carbon\Carbon();
    $log_string = $freshTimestamp.' '.$log['ip_address'].' VL'.$log['verbose_level'].' '.$logger->id.' '.$log['event_name'].' ['.$log['custom_parameter'].'] ['.$log['request_uri'].']'.PHP_EOL;

    File::append(Config::get('settings.log_file'),$log_string);

});