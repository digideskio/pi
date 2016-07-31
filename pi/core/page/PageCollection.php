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

namespace Pi\Core\Page;

use Pi\Lib\Str;

class PageCollection implements \IteratorAggregate {
	/** @var Page[] Pages faisant partie de la collection */
	private $pages;

	/**
	 * Constructeur
	 */
	public function __construct(array $pages) {
		// Récupération des pages passées en paramètre
		$this->pages = $pages;

		// Toutes les pages sont gardées excepté la page « error »
		$this->pages = array_filter($this->pages, function($slug) {
			return $slug != 'error';
		}, ARRAY_FILTER_USE_KEY);
	}

	/**
	 * Pages dont le slug commence par
	 */
	public function slugStartsWith(string $name): PageCollection {
		$pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::startsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return new static($pages);
	}

	/**
	 * Pages dont le slug finit par
	 */
	public function slugEndsWith(string $name): PageCollection {
		$pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::endsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return new static($pages);
	}

	/**
	 * Pages dont le slug contient
	 */
	public function slugContains(string $name): PageCollection {
		$pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::contains($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return new static($pages);
	}

	/**
	 * Pages qui contiennent le champ
	 */
	public function containsField(string $fieldName): PageCollection {
		$pages = array_filter($this->pages, function($page) use ($fieldName) {
			/** @var Page $page */
			return array_key_exists($fieldName, $page->getFields());
		});

		return new static($pages);
	}

	/**
	 * @todo Pages dont le champ vaut
	 */
	public function fieldValueIs(string $fieldName, $fieldValue): PageCollection {
		$pages = array_filter($this->pages, function($page) {
			return true;
		});

		return new static($pages);
	}

	/**
	 * Pages dont le modèle est
	 */
	public function withModel(string $modelName) {
		$pages = array_filter($this->pages, function($page) use ($modelName) {
			/** @var $page Page */
			return $page->getModel() == $modelName;
		});

		return new static($pages);
	}

	/**
	 * Itérateur : le slug de la page en clé et la page en valeur
	 */
	public function getIterator(): \ArrayIterator {
		return new \ArrayIterator($this->pages);
	}
}
