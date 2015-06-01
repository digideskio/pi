<?php

namespace Pi\Core;

class Config {
	public static $data = [];

	public static function set($key, $value) {
		return static::$data[$key] = $value;
	}

	public static function get($key = null, $default = null) {
		if (is_null($key))
			return static::$data;

		return isset(static::$data[$key]) ? static::$data[$key] : $default;
	}

	public static function remove($key = null) {
		if (is_null($key))
			return static::$data = [];

		unset(static::$data[$key]);
	}
}
