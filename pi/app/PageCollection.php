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

use Pi\Lib\Str;

class PageCollection implements \IteratorAggregate {
	/** @var Page[] Pages faisant partie de la collection */
	private $pages;

	/**
	 * Cache de toutes les pages, pour éviter de tout recalculer à chaque fois
	 *
	 * @var PageCollection
	 */
	private static $cacheAllPages = null;

	/**
	 * Récupérer toutes les pages
	 *
	 * @return Liste de toutes les pages du site
	 */
	public static function getAllPages(): PageCollection {
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

		foreach ($dirs as $dir) {
			$page = new Page($dir);
			$pages[$dir] = $page->getLastVersion();
		}

		// Création de la collection
		$self = new static($pages);

		// Complète le cache avec les pages récupérées
		static::$cacheAllPages = $self;

		// Retourne la version désormais en cache
		return static::$cacheAllPages;
	}

	/**
	 * @param Page[] $pages
	 */
	protected function __construct(array $pages) {
		// Récupération des pages passées en paramètre
		$this->pages = $pages;

		// Toutes les pages sont gardées excepté la page « error »
		$this->pages = array_filter($this->pages, function($slug) {
			return $slug != 'error';
		}, ARRAY_FILTER_USE_KEY);
	}

	/**
	 * Pages dont le slug commence par
	 *
	 * @param $name
	 *
	 * @return $this
	 */
	public function slugStartsWith(string $name): PageCollection {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::startsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/**
	 * Pages dont le slug finit par
	 *
	 * @param $name
	 *
	 * @return $this
	 */
	public function slugEndsWith(string $name): PageCollection {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::endsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/**
	 * Pages dont le slug contient
	 *
	 * @param $name
	 *
	 * @return $this
	 */
	public function slugContains(string $name): PageCollection {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::contains($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/**
	 * Pages qui contiennent le champ
	 *
	 * @param $fieldName
	 *
	 * @return $this
	 */
	public function containsField(string $fieldName): PageCollection {
		$this->pages = array_filter($this->pages, function($page) use ($fieldName) {
			return isset($page['fields'][$fieldName]);
		});

		return $this;
	}

	/**
	 * @todo Pages dont le champ vaut
	 *
	 * @param $fieldName
	 * @param mixed $fieldValue
	 *
	 * @return $this
	 */
	public function fieldValueIs(string $fieldName, $fieldValue): PageCollection {
		$this->pages = array_filter($this->pages, function($page) {
			return true;
		});

		return $this;
	}

	/**
	 * Pages dont le modèle est
	 *
	 * @param $modelName
	 *
	 * @return $this
	 */
	public function withModel(string $modelName) {
		$this->pages = array_filter($this->pages, function($page) use ($modelName) {
			return $page['model'] == $modelName;
		});

		return $this;
	}

	/**
	 * Itérateur : le slug de la page en clé et la page en valeur
	 *
	 * @return \Generator
	 */
	public function getIterator(): \Generator {
		foreach ($this->pages as $slug => $page)
			yield $slug => $page;
	}
}
