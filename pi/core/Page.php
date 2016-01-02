<?php

namespace Pi\Core;

use Pi\Lib\Yaml;

class Page {
	public static function getVersion($slug, $version) {
		$file = 'content/pages/' . $slug . '/' . $version . '.yaml';

		if (file_exists($file)) {
			return Yaml::read($file);
		} else {
			throw new Exception('Version \'' . $version . '\' de \'' . $slug . '\' inexistante.');
		}
	}

	public static function getLastVersion($slug) {
		$f = 'content/pages/' . $slug;

		if (!is_dir($f))
			return false;

		$a = opendir($f);

		if (!$a)
			return false;

		$version = 0;

		while ($b = readdir($a)) {
			if ($b != '.' && $b != '..') {
				$c = $f . '/' . $b;

				if (is_file($c)) {
					$d = (int) substr($b, 0, -4);

					if ($d > $version)
						$version = $d;
				}
			}
		}

		if ($version == 0)
			return false;

		return self::getVersion($slug, $version);
	}

	public static function getAllVersions($slug) {
		$versions = [];

		$f = 'content/pages/' . $slug;

		if (!is_dir($f))
			return [];

		$a = opendir($f);

		if (!$a)
			return [];

		while ($b = readdir($a)) {
			if ($b != '.' && $b != '..') {
				$c = $f . '/' . $b;

				if (is_file($c)) {
					$d = (int) substr($b, 0, -5);
					$versions[] = $d;
				}
			}
		}

		return array_reverse($versions);
	}

	public static function getFormatedContent($slug) {
		$table_contents = self::getTitles($slug);

		$toc = '';

		if (!empty($table_contents))
			$toc = '
				<div class="table-contents">
					' . self::array2ul($table_contents) . '
				</div>
			';

		$parser = new ParsedownAylab();

		$content = $parser
			->setBreaksEnabled(true)
			->text($this->content);

		$offset = strpos($content, '<h2 id="');

		// Si on trouve un <h2>, on éclate le contenu en deux,
		// et on ajoute la table des matières avant le titre
		if ($offset !== false) {
			$part1 = substr($content, 0, $offset);
			$part2 = substr($content, $offset);

			$content = $part1 . $toc . $part2;
		}

		return $content;
	}

	/*
	public static function getTitles($slug) {
		$final = [];

		$lines = explode("\n", $this->content);

		$lvl2 = '';
		$lvl3 = '';
		$lvl4 = '';
		$lvl5 = '';

		for ($i = 0 ; $i < count($lines) ; $i++) {
			$line = trim($lines[$i]);

			if (preg_match('/-{2,}/', $line) && preg_match('/.+/', $lines[$i - 1])) {
				$lvl2 = $lines[$i - 1];
				$final[$lvl2] = [];
			} else if (preg_match('/######.+/', $line)) {
				$lvl6 = trim(preg_replace('/^######/', '', $line));
				$final[$lvl2][$lvl3][$lvl4][$lvl5][$lvl6] = [];
			} else if (preg_match('/#####.+/', $line)) {
				$lvl5 = trim(preg_replace('/^#####/', '', $line));
				$final[$lvl2][$lvl3][$lvl4][$lvl5] = [];
			} else if (preg_match('/####.+/', $line)) {
				$lvl4 = trim(preg_replace('/^####/', '', $line));
				$final[$lvl2][$lvl3][$lvl4] = [];
			} else if (preg_match('/###.+/', $line)) {
				$lvl3 = trim(preg_replace('/^###/', '', $line));
				$final[$lvl2][$lvl3] = [];
			} else if (preg_match('/##.+/', $line)) {
				$lvl2 = trim(preg_replace('/^##/', '', $line));
				$final[$lvl2] = [];
			}
		}

		return $final;
	}

	public static function array2ul($array) {
		$out = '<ul>';

		foreach ($array as $key => $elem){
			if (!is_array($elem))
				$out .= '<li>' . $key . ':' . $elem . '</li>';
			else if (empty($elem))
				$out .= '<li><a href="#' . ParsedownAylab::gen_slug($key) . '">' . $key . '</a></li>';
			else if (!empty($elem))
				$out .= '<li><a href="#' . ParsedownAylab::gen_slug($key) . '">' . $key . '</a>' . self::array2ul($elem) . '</li>';
		}

		$out .= '</ul>';

		return $out;
	}
	*/
}