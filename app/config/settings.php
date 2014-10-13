<?php
/**
 * Created by PhpStorm.
 * User: rahman
 * Date: 13/10/14
 * Time: 14:10
 */

$list = array();

$format = function(&$list, $keys, $val) use(&$format) {
    $keys ? $format($list[array_shift($keys)], $keys, $val) : $list = $val;
};
if(Schema::hasTable('settings')) {
    foreach (Setting::all() as $setting) {
        $format($list, explode('.', $setting->name), $setting->value);
    }
}

return $list;