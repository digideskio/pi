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

namespace Pi\App;

use Pi\Core;

class Page {
	/** @var string Slug de la page */
	private $slug;

	/**
	 * Constructeur
	 *
	 * @param string $slug
	 */
	public function __construct($slug) {

	}

	/**
	 * @todo
	 *
	 * Récupérer la dernière version de la page
	 *
	 * @return Core\Page;
	 */
	public function getLastVersion() {
		$page = Core\Page::fromFile($this->slug . '/1.json');

		return $page;
	}

	/**
	 * @todo
	 *
	 * Récupérer la liste des versions de la page
	 *
	 * @return array
	 */
	public function getListVersions() {

	}
}
