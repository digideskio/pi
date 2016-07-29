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

class Json {
	/**
	 * @param string $file Fichier dans lequel écrire
	 * @param array $array Tableau à écrire dans le fichier (sera encodé au
	 *               format JSON sous forme de chaine)
	 *
	 * @return bool true en cas de succès, false sinon
	 */
	public static function write(string $file, array $array): bool {
		$encodedArray = static::encode($array);

		return file_put_contents($file, $encodedArray) !== false;
	}

	/**
	 * @param string $fileName Fichier à décoder
	 *
	 * @return mixed
	 */
	public static function read(string $fileName) {
		$content = (string) file_get_contents($fileName);

		return static::decode($content);
	}

	/**
	 * @param array $array Données à encoder : données PHP => chaine JSON
	 *
	 * @return string Les données au format JSON
	 */
	public static function encode(array $array): string {
		return json_encode($array, JSON_PRETTY_PRINT);
	}

	/**
	 * @param string $string Chaine à décoder : chaine JSON => objet PHP
	 *
	 * @return mixed
	 */
	public static function decode(string $string) {
		return json_decode($string, false);
	}
}
