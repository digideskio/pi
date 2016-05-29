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
	protected $path;
	protected $query;

	/**
	 * Initialise le chemin courant
	 */
	public function __construct() {
		$this->path = 'home';
		$this->query = '';

		if (isset($_SERVER['PATH_INFO'])) {
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$parts = explode('&', $matches[2]);
			$query = [];

			foreach ($parts as $part)
				$query[] = explode('=', $part, 2);

			$this->path = trim($matches[1], '/');
			$this->query = $query;
		}

		if (empty($this->path))
			$this->path = 'home';
	}

	public function getPath() {
		return $this->path;
	}

	public function getQuery() {
		return $this->query;
	}
}
