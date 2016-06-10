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

class Str {
	/**
	 * @param $txt
	 * 
	 * @return La chaine sans accent
	 */
	public static function stripAccents(string $txt): string {
		return strtr(utf8_decode($txt), utf8_decode(
			'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

	/**
	 * @param $txt
	 *
	 * @return La chaine « slugée »
	 */
	public static function slug(string $txt): string {
		// on remplace les apostrophes et les espaces par des tirets
		$txt = str_replace(['\'', ' '], '-', $txt);

		// on retire les accents des caractères spéciaux
		$txt = static::stripAccents($txt);

		// on ne garde que les caractères alphanumérique et les tirets
		$txt = preg_replace('~[^a-zA-Z0-9-]~', '', $txt);

		// on met en minuscule
		$txt = strtolower($txt);

		// on remplace les groupe de tirets par un seul
		$txt = preg_replace('~-+~', '-', $txt);

		// on retire les tirets initiaux et finaux s'il y en a
		$txt = trim($txt, '-');

		return $txt;
	}

	/**
	 * @todo Possibilité de passer le caractère de saut de ligne
	 *
	 * @param $txt
	 *
	 * @return Découpe les lignes d'une chaine et les retournent sous forme de
	 *         tableau
	 */
	public static function lines(string $txt): array {
		return str_split(EOL, $txt);
	}

	/**
	 * @param $string
	 *
	 * @return true si la chain est une URL, false sinon
	 */
	public static function isURL(string $string): bool {
		return (bool) filter_var($string, FILTER_VALIDATE_URL);
	}

	/**
	 * @param $length
	 *
	 * @return Chaine générée aléatoirement
	 */
	public static function random(int $length = 8): string {
		$chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
		$lengthChars = count($chars);

		$string = '';

		for ($i = 0 ; $i < $length ; $i++)
			$string .= $chars[rand(0, $lengthChars)];

		return $string;
	}

	/**
	 * @param $txt
	 * @param $nbWords
	 * @param $after
	 *
	 * @return Garde $nbWords de la chaine $txt
	 */
	public static function splitWords(string $txt,
		                              int $nbWords = 50,
		                              string $after = '…'): string {
		$txt = strip_tags($txt);

		$words = explode(' ', $txt);

		if (count($words) < $nbWords)
			return $txt;

		$txt = '';

		for ($i = 0 ; $i < $nbWords ; $i++)
			$txt .= $words[$i] . ' ';

		$txt = substr($txt, 0, -1);
		$txt .= $after;

		return $txt;
	}

	/**
	 * @param $txt
	 * @param $needle
	 * @param $insensitive
	 *
	 * @return true si $txt contient $needle, false sinon
	 */
	public static function contains(string $txt,
		                            string $needle,
		                            bool $insensitive = true): bool {
		if ($insensitive) {
			$txt = strtolower($txt);
			$needle = strtolower($needle);
		}

		return strstr($txt, $needle) ? true : false;
	}

	/**
	 * @param $str
	 * @param $needle
	 *
	 * @return true si $str commence par $needle, false sinon
	 */
	public static function startsWith(string $str, string $needle): bool {
		return $needle === '' || strpos($str, $needle) === 0;
	}

	/**
	 * @param $str
	 * @param $needle
	 *
	 * @return true si $str se termine par $needle, false sinon
	 */
	public static function endsWith(string $str, string $needle): bool {
		return $needle === '' || substr($str, -strlen($needle)) === $needle;
	}
}
