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
    if (preg_match("/^[A-Za-z][A-Za-z0-9]{5,31}$/", $value)) {
        $ret = TRUE;
    }
    return $ret;
});