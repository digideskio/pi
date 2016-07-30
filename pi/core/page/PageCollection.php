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
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::startsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/**
	 * Pages dont le slug finit par
	 */
	public function slugEndsWith(string $name): PageCollection {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::endsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/**
	 * Pages dont le slug contient
	 */
	public function slugContains(string $name): PageCollection {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
			return Str::contains($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/**
	 * Pages qui contiennent le champ
	 */
	public function containsField(string $fieldName): PageCollection {
		$this->pages = array_filter($this->pages, function($page) use ($fieldName) {
			/** @var Page $page */
			return array_key_exists($fieldName, $page->getFields());
		});

		return $this;
	}

	/**
	 * @todo Pages dont le champ vaut
	 */
	public function fieldValueIs(string $fieldName, $fieldValue): PageCollection {
		$this->pages = array_filter($this->pages, function($page) {
			return true;
		});

		return $this;
	}

	/**
	 * Pages dont le modèle est
	 */
	public function withModel(string $modelName) {
		$this->pages = array_filter($this->pages, function($page) use ($modelName) {
			return $page['model'] == $modelName;
		});

		return $this;
	}

	/**
	 * Itérateur : le slug de la page en clé et la page en valeur
	 */
	public function getIterator(): \Generator {
		foreach ($this->pages as $slug => $page)
			yield $slug => $page;
	}
}
