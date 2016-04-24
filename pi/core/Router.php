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

class Router {
	protected static $path = '';
	protected static $query = [];

	/**
	 * Initialise le chemin courant
	 */
	public static function initializePath() {
		static::$path = 'home';
		static::$query = '';

		if (isset($_SERVER['PATH_INFO'])) {
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$parts = explode('&', $matches[2]);
			$query = [];

			foreach ($parts as $part)
				$query[] = explode('=', $part, 2);

			static::$path = trim($matches[1], '/');
			static::$query = $query;
		}

		if (empty(static::$path))
			static::$path = 'home';
	}

	public static function getPath() {
		return static::$path;
	}

	public static function getQuery() {
		return static::$query;
	}
}
