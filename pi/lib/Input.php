<?php

namespace Pi\Lib;

class Input {
	public static function get($name, $default = '') {
		if (isset($_POST[$name]))
			return $_POST[$name];
		else
			return $default;
	}
}
