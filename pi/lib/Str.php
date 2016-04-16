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
	 * @param string $txt
	 * 
	 * @return string
	 */
	public static function stripAccents($txt) {
		return strtr(utf8_decode($txt), utf8_decode(
			'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

	/**
	 * @param string $txt
	 *
	 * @return string
	 */
	public static function slug($txt) {
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
	 * @param string $txt
	 *
	 * @return array
	 */
	public static function lines($txt) {
		return str_split(EOL, $txt);
	}

	/**
	 * @param string $string
	 *
	 * @return bool
	 */
	public static function isURL($string) {
		return (bool) filter_var($string, FILTER_VALIDATE_URL);
	}

	/**
	 * @param int $length
	 *
	 * @return string
	 */
	public static function random($length = 8) {
		$chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
		$lengthChars = count($chars);

		$string = '';

		for ($i = 0 ; $i < $length ; $i++)
			$string .= $chars[rand(0, $lengthChars)];

		return $string;
	}

	/**
	 * @param string $txt
	 * @param int $nbWords
	 * @param string $after
	 *
	 * @return string
	 */
	public static function splitWords($txt, $nbWords = 50, $after = '…') {
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
	 * @param string $txt
	 * @param string $needle
	 * @param bool $insensitive
	 *
	 * @return bool
	 */
	public static function contains($txt, $needle, $insensitive = true) {
		if ($insensitive) {
			$txt = strtolower($txt);
			$needle = strtolower($needle);
		}

		return strstr($txt, $needle) ? true : false;
	}

	/**
	 * @param string $str
	 * @param string $needle
	 *
	 * @return bool
	 */
	public static function startsWith($str, $needle) {
		return $needle === '' || strpos($str, $needle) === 0;
	}

	/**
	 * @param string $str
	 * @param string $needle
	 *
	 * @return bool
	 */
	public static function endsWith($str, $needle) {
		return $needle === '' || substr($str, -strlen($needle)) === $needle;
	}
}
