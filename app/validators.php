<?php
/**
 * Created by PhpStorm.
 * User: rahman
 * Date: 11/4/14
 * Time: 5:09 AM
 */

Validator::extend('must_alpha_num', function($attribute, $value, $parameters)
{
    $ret = FALSE;
    if (preg_match("/^[a-z][a-z0-9]{3,31}$/", $value)) {
        $ret = TRUE;
    }
    return $ret;
});

Validator::extend('domain', function($attribute, $value, $parameters)
{
    if(!preg_match("/^(.*?)\.(.*)/", $value)) {
        return false;
    }
    return true;
});

Validator::extend('ip_hostname', function($attribute, $value, $parameters)
{
    if(!preg_match("/^([a-z0-9]+[\.][a-z0-9]+)*$/", $value)) {
        return false;
    }
    return true;
});