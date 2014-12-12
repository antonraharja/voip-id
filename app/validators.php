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