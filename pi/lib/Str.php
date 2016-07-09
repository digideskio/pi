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

class Str {
	/**
	 * Prend une chaine et la retourne sans les accents
	 *
	 * @param $txt La chaine dont on veut enlever les accents
	 * 
	 * @return La chaine sans accent
	 */
	public static function stripAccents(string $txt): string {
		return strtr(utf8_decode($txt), utf8_decode(
			'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

	/**
	 * « Slugifie » une chaine. C'est-à-dire qu'elle devient tout en minuscule,
	 * que les espaces sont remplacés par des tirets et que seuls les caractères
	 * A-Z, a-z et le tiret sont conservés
	 *
	 * @param $txt Chaine à « sluger »
	 * @param $default Valeur à utiliser si le slug final est vide
	 *
	 * @return La chaine « slugée »
	 */
	public static function slug(string $txt,
		                          string $default = 'unnamed'): string {
		// On remplace les apostrophes et les espaces par des tirets
		$txt = str_replace(['\'', ' '], '-', $txt);

		// On retire les accents des caractères spéciaux
		$txt = static::stripAccents($txt);

		// On ne garde que les caractères alphanumérique et les tirets
		$txt = preg_replace('~[^a-zA-Z0-9-]~', '', $txt);

		// On met en minuscule
		$txt = strtolower($txt);

		// On remplace les groupe de tirets par un seul
		$txt = preg_replace('~-+~', '-', $txt);

		// On retire les tirets initiaux et finaux s'il y en a
		$txt = trim($txt, '-');

		// Si la chaine finale est vide, on lui donne une valeur par défaut
		$txt = $txt ?? $default;

		return $txt;
	}

	/**
	 * @param $txt La chaine à découper
	 * @param $newlineChar Caractère de saut de ligne, par défaut « \n »
	 *
	 * @return Découpe les lignes d'une chaine et les retournent sous forme de
	 *         tableau
	 */
	public static function lines(string $txt,
	                             string $newlineChar = "\n"): array {
		$txt = str_replace("\r\n", "\n", $txt);
		$txt = str_replace("\r", "\n", $txt);

		return str_split("\n", $newlineChar);
	}

	/**
	 * @param $string La chaine à tester
	 *
	 * @return true si la chaine est une URL, false sinon
	 */
	public static function isURL(string $string): bool {
		return (bool) filter_var($string, FILTER_VALIDATE_URL);
	}

	/**
	 * Générer une chaine aléatoirement avec une longueur donnée
	 *
	 * @param $length Longueur de la chaine à générer
	 *
	 * @return Chaine générée aléatoirement
	 */
	public static function random(int $length): string {
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
	 * @param $txt La chaine à tester
	 * @param $needle La chaine interne à tester
	 * @param $insensitive Sensibilité à la casse
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
	 * @param $str La chaine à tester
	 * @param $needle La chaine interne à tester
	 *
	 * @return true si $str commence par $needle, false sinon
	 */
	public static function startsWith(string $str, string $needle): bool {
		return $needle === '' || strpos($str, $needle) === 0;
	}

	/**
	 * @param $str La chaine à tester
	 * @param $needle La chaine interne à tester
	 *
	 * @return true si $str se termine par $needle, false sinon
	 */
	public static function endsWith(string $str, string $needle): bool {
		return $needle === '' || substr($str, -strlen($needle)) === $needle;
	}
}
