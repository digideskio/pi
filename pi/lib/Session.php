<?php

namespace Pi\Lib;

class Session {
	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public static function get($key) {
		return $_SESSION[$key];
	}

	public static function remove($key) {
		unset($_SESSION[$key]);
	}

	public static function exists($key) {
		return isset($_SESSION[$key]);
	}

	public static function start() {
		session_start();
	}

	public static function stop() {
		session_destroy();
	}

	public static function restart() {
		static::stop();
		static::start();
	}
}
