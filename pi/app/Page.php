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

namespace Pi\App;

use Pi\Core;

class Page {
	/** @var string Slug de la page */
	private $slug;

	/**
	 * Constructeur
	 *
	 * @param $slug
	 */
	public function __construct(string $slug) {
		$this->slug = $slug;
	}

	/**
	 * @todo
	 *
	 * Récupérer la dernière version de la page
	 *
	 * @throws \Exception
	 */
	public function getLastVersion(): Core\Page {
		$versions = [];

		foreach (glob($this->slug . '/*') as $pathfile) {
			$filename = basename($pathfile);

			$version = explode('.', $filename)[0];
			$versions[] = (int) $version;
		}

		if (empty($versions))
			throw new \Exception('Page "' . $this->slug . '" does not exists');

		$lastVersion = max($versions);

		$page = Core\Page::fromFile($this->slug . '/' . $lastVersion . '.json');

		return $page;
	}

	/**
	 * @todo
	 *
	 * Récupérer la liste des versions de la page
	 */
	public function getListVersions(): array {
		return [];
	}
}
