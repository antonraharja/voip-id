<?php

// enforced to declare function _() for gettext replacement if no PHP gettext extension found
// it is also possible to completely remove gettext and change multi-lang with translation array

if (!function_exists('_')) {
	function _($text) {
		return $text;
	}
}

if (!function_exists('_n')) {
	function _n($text) {
		return $text;
	}
}
