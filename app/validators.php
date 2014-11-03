<?php
/**
 * Created by PhpStorm.
 * User: rahman
 * Date: 11/4/14
 * Time: 5:09 AM
 */

Validator::extend('must_alpha_num', function($attribute, $value, $parameters)
{
    return !is_numeric($value);
});