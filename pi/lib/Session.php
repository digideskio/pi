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

declare(strict_types=1);

namespace Pi\Lib;

/**
 * @todo Du fait de l'utilisation de $_SESSION, les variables sont partagées
         entre toutes les instances de cette classe, ce qui peut poser problème
 */
class Session {
	/**
	 * @param $key
	 * @param mixed $value
	 */
	public function set(string $key, $value) {
		$_SESSION[$key] = $value;
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function get(string $key) {
		return $_SESSION[$key];
	}

	/**
	 * @param $key
	 */
	public function remove(string $key) {
		unset($_SESSION[$key]);
	}

	/**
	 * @param $key
	 *
	 * @return true si la clé est enregistrée dans la session, false sinon
	 */
	public function exists(string $key): bool {
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
