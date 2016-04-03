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
	public static function init() {
		if (!isset($_SESSION['errors']))
			$_SESSION['errors'] = [];

		if (!isset($_SESSION['success']))
			$_SESSION['success'] = [];
	}

	public static function clean() {
		$_SESSION['errors'] = [];
		$_SESSION['success'] = [];
	}

	public static function pushError($error) {
		array_push($_SESSION['errors'], $error);
	}

	public static function pushSuccess($success) {
		array_push($_SESSION['success'], $success);
	}

	public static function hasErrors() {
		return count($_SESSION['errors']) > 0;
	}

	public static function hasNoErrors() {
		return !self::hasErrors();
	}

	public static function hasSuccess() {
		return count($_SESSION['success']) > 0;
	}

	public static function getErrors() {
		return $_SESSION['errors'];
	}

	public static function getSuccess() {
		return $_SESSION['success'];
	}
}
