<?php
/**
 * Created by PhpStorm.
 * User: rahman
 * Date: 11/5/14
 * Time: 8:47 AM
 */

Event::listen('auth.login', function($user)
{
    Event::fire('logger', array(array('login',array('username'=>$user->username),2)));
});

Event::listen('auth.logout', function($user)
{
    Event::fire('logger', array(array('logout',array('username'=>$user->username),2)));
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

    Logger::create($log);
});