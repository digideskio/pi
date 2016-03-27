<?php

/**
 * This file is part of Pi.
 *
 * Pi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Pi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Pi.  If not, see <http://www.gnu.org/licenses/>.
*/

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
