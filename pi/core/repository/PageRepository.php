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

namespace Pi\Core\Repository;

use Pi\Core\Page\Page;
use Pi\Lib\Json;

class PageRepository implements IRepository {
	/**
	 * Cache de toutes les pages, pour éviter de tout recalculer à chaque fois
	 *
	 * @var array
	 */
	private static $cacheAllPages = null;

	public function findAll() {
		// Retourne les pages en cache s'il y en a
		if (static::$cacheAllPages != null)
			return static::$cacheAllPages;

		// Récupère tous les chemins du dossier des pages
		$dirs = scandir(PI_DIR_PAGES);

		// Supprime les chemins « . » et « .. »
		$dirs = array_filter($dirs, function($dir) {
			return ($dir != '.' && $dir != '..');
		});

		// Redéfinition de l'indexation du tableau
		$dirs = array_values($dirs);

		// Récupération de la dernière version de chacune des pages
		$pages = [];

		foreach ($dirs as $dir)
			$pages[$dir] = static::findBySlug($dir);

		// Complète le cache avec les pages récupérées
		static::$cacheAllPages = $pages;

		// Retourne la version désormais en cache
		return static::$cacheAllPages;
	}

	public function findBySlug($slug) {
		$filename = $this->getLastVersionFileName($slug);

		if (!file_exists($filename))
			throw new \Exception('File "' . $filename . '" does not exists.');

		$json = Json::read($filename);

		$createdAt = \DateTime::createFromFormat(
			\DateTime::ISO8601,
			$json->created_at);

		$updatedAt = \DateTime::createFromFormat(
			\DateTime::ISO8601,
			$json->updated_at);

		$page = new Page();

		$page->setTitle($json->title);
		$page->setModel($json->model);
		$page->setCreatedAt($createdAt);
		$page->setUpdatedAt($updatedAt);
		$page->setFields((array) $json->fields);

		return $page;
	}

	/**
	 * Récupérer la dernière version de la page
	 *
	 * @throws \Exception
	 */
	public function getLastVersionFileName($slug) {
		$versions = [];

		foreach (glob(PI_DIR_PAGES . $slug . '/*') as $pathfile) {
			$filename = basename($pathfile);

			$version = explode('.', $filename)[0];
			$versions[] = (int) $version;
		}

		if (empty($versions))
			throw new \Exception('Page "' . $slug . '" does not exists');

		$lastVersion = max($versions);

		return PI_DIR_PAGES . $slug . '/' . $lastVersion . '.json';
	}

	public function save($page) {
		/** @var $page Page */
		$slug = $page->getSlug();

		mkdir(PI_DIR_PAGES . $slug, 0655, true);

		$page->saveToFile(PI_DIR_PAGES . $slug . '/' . time() . '.json');
	}

	public function remove($page) {

	}
}
