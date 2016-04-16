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

namespace Pi\Core;

class Config {
	/** @var array */
	public static $data = [];

	/**
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public static function set($key, $value) {
		return static::$data[$key] = $value;
	}

	/**
	 * @param string|null $key
	 * @param mixed $default
	 *
	 * @return array|mixed|null
	 */
	public static function get($key = null, $default = null) {
		if (is_null($key))
			return static::$data;

		return isset(static::$data[$key]) ? static::$data[$key] : $default;
	}

	/**
	 * @param string|null $key
	 *
	 * @return array
	 */
	public static function remove($key = null) {
		if (is_null($key))
			return static::$data = [];

		unset(static::$data[$key]);
	}
}
