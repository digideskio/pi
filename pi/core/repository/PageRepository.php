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

namespace Pi\Core\Repository;

use Pi\Core\Page\Page;
use Pi\Core\Page\PageOutputter;
use Pi\Lib\FileSystem;
use Pi\Lib\Json;

class PageRepository implements IRepository {
	/**
	 * Cache de toutes les pages, pour éviter de tout recalculer à chaque fois
	 *
	 * @var array
	 */
	private static $cacheAllPages = null;

	/**
	 * Récupérer toutes les pages
	 */
	public function getAll(): array {
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
			$pages[$dir] = static::getBySlug($dir);

		// Complète le cache avec les pages récupérées
		static::$cacheAllPages = $pages;

		// Retourne la version désormais en cache
		return static::$cacheAllPages;
	}

	/**
	 * Récupérer une page par son slug
	 */
	public function getBySlug(string $slug) {
		$fileName = $this->getLastVersionFileName($slug);

		if (!file_exists($fileName))
			throw new \Exception('File "' . $fileName . '" does not exists.');

		$json = Json::read($fileName);

		$createdAt = \DateTime::createFromFormat(
			\DateTime::ISO8601,
			$json->created_at);

		$updatedAt = \DateTime::createFromFormat(
			\DateTime::ISO8601,
			$json->updated_at);

		$page = new Page();

		$page->setTitle($json->title);
		$page->setSlug($slug);
		$page->setModel($json->model);
		$page->setCreatedAt($createdAt);
		$page->setUpdatedAt($updatedAt);
		$page->setFields((array) $json->fields);

		return $page;
	}

	/**
	 * Récupérer la dernière version de la page
	 */
	public function getLastVersionFileName(string $slug): string {
		$versions = [];

		foreach (glob(PI_DIR_PAGES . $slug . '/*') as $pathfile) {
			$fileName = basename($pathfile);

			$version = explode('.', $fileName)[0];
			$versions[] = (int) $version;
		}

		if (empty($versions))
			throw new \Exception('Page "' . $slug . '" does not exists');

		$lastVersion = max($versions);

		return PI_DIR_PAGES . $slug . '/' . $lastVersion . '.json';
	}

	/**
	 * Enregistrer la page
	 */
	public function save($page): bool {
		/** @var $page Page */
		$slug = $page->getSlug();

		$dir = PI_DIR_PAGES . $slug;

		if (!is_dir($dir))
			mkdir($dir, 0777, true);

		$outputter = new PageOutputter($page);
		$fileName = PI_DIR_PAGES . $slug . '/' . time() . '.json';
		$bytesWritter = file_put_contents($fileName, $outputter->json());

		return $bytesWritter !== false;
	}

	/**
	 * Supprimer la page
	 */
	public function remove($page): bool {
		/** @var Page $page */
		$dir = PI_DIR_PAGES . $page->getSlug();

		return FileSystem::removeDirectory($dir);
	}
}
