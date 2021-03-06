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

class Markdown {
	/**
	 * Chaine Markdown => HTML
	 */
	public static function html(string $txt) {
		$parse = new \ParsedownExtra();

		return $parse->text($txt);
	}

	/**
	 * Fichier Markdown => HTML
	 */
	public static function read(string $fileName) {
		return static::html(file_get_contents($fileName));
	}
}
