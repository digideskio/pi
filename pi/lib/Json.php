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

class Json {
	public static function write($file, $array) {
		$encodedArray = static::encode($array);

		return static::encode($encodedArray);
	}

	public static function read($file) {
		$content = file_get_contents($file);

		return static::decode($content);
	}

	public static function encode($array) {
		return json_encode($array);
	}

	public static function decode($string) {
		return json_decode($string, true);
	}
}