<?php

namespace Pi\Lib;

use ParsedownExtra;

class Markdown {
	public static function html($txt) {
		$parse = new ParsedownExtra();

		return $parse->text($txt);
	}

	public static function read($file) {
		return static::html(file_get_contents($file));
	}
}
