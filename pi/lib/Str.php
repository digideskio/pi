<?php

namespace Pi\Lib;

class Str {
	public static function stripAccents($txt) {
		return strtr(utf8_decode($txt), utf8_decode(
			'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
			'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

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

	public static function lines($txt) {
		return split(EOL, $txt);
	}

	public static function isURL($string) {
		return filter_var($string, FILTER_VALIDATE_URL);
	}

	public static function random($length = 8) {
		$chars = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
		$lengthChars = count($chars);

		$string = '';

		for ($i = 0 ; $i < $length ; $i++)
			$string .= $chars[rand(0, $lengthChars)];

		return $string;
	}

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

	public static function contains($txt, $needle, $insensitive = true) {
		if ($insensitive) {
			$txt    = strtolower($txt);
			$needle = strtolower($needle);
		}

		return strstr($txt, $needle) ? true : false;
	}

	public static function startsWith($str, $needle) {
		return $needle === '' || strpos($str, $needle) === 0;
	}

	public static function endsWith($str, $needle) {
		return $needle === '' || substr($str, -strlen($needle)) === $needle;
	}
}
