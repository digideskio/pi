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

class Flash {
	/**
	 * Initilisation du flash
	 */
	public function __construct() {
		if (!isset($_SESSION['errors']))
			$_SESSION['errors'] = [];

		if (!isset($_SESSION['success']))
			$_SESSION['success'] = [];
	}

	/**
	 * Nettoyage du flash
	 */
	public function clean() {
		$_SESSION['errors'] = [];
		$_SESSION['success'] = [];
	}

	/**
	 * @param $error
	 */
	public function pushError(string $error) {
		array_push($_SESSION['errors'], $error);
	}

	/**
	 * @param $success
	 */
	public function pushSuccess(string $success) {
		array_push($_SESSION['success'], $success);
	}

	/**
	 *
	 */
	public function hasErrors(): bool {
		return count($_SESSION['errors']) > 0;
	}

	/**
	 *
	 */
	public function hasNoErrors(): bool {
		return !$this->hasErrors();
	}

	/**
	 *
	 */
	public function hasSuccess(): bool {
		return count($_SESSION['success']) > 0;
	}

	/**
	 *
	 */
	public function getErrors(): array {
		return $_SESSION['errors'];
	}

	/**
	 *
	 */
	public function getSuccess(): array {
		return $_SESSION['success'];
	}
}
