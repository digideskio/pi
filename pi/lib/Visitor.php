<?php

namespace Pi\Lib;

class Visitor {
	public static function ip() {
		return $_SERVER['REMOTE_ADDR'];
	}
	
	public static function ua() {
		return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
	}
}
