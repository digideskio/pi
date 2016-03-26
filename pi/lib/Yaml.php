<?php

namespace Pi\Lib;

use Spyc;

class Yaml {
	public static function encode($array) {
		return Spyc::YAMLDump($array, false, false, true);
	}

	public static function write($file, $array) {
		return file_put_contents($file, static::encode($array));
	}

	public static function decode($yaml) {
		return Spyc::YAMLLoad($yaml);
	}

	public static function read($file) {
		return Spyc::YAMLLoad($file);
	}
}
