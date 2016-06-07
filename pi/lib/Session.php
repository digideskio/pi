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

class Session {
	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get($key) {
		return $_SESSION[$key];
	}

	/**
	 * @param string $key
	 */
	public function remove($key) {
		unset($_SESSION[$key]);
	}

	/**
	 * @param string $key
	 *
	 * @return bool
	 */
	public function exists($key) {
		return isset($_SESSION[$key]);
	}

	/**
	 * Ouvre la session
	 */
	public function start() {
		session_start();
	}

	/**
	 * Ferme la session
	 */
	public function stop() {
		session_destroy();
	}

	/**
	 * Relance la session
	 */
	public function restart() {
		$this->stop();
		$this->start();
	}
}
