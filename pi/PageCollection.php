<?php

namespace Pi;

use IteratorAggregate;

use Pi\Core\Page;
use Pi\Lib\Str;

class PageCollection implements IteratorAggregate {
	/// Pages faisant partie de la collection
	private $pages;

	/// Cache de toutes les pages, pour éviter de tout recalculer à chaque fois
	private static $cacheAllPages = null;

	public function __construct($pages) {
		// Récupération des pages passées en paramètre
		$this->pages = $pages;

		// Toutes les pages sont gardées excepté la page « error »
		$this->pages = array_filter($this->pages, function($page) {
			return $page != 'error';
		});
	}

	/// Pages dont le slug commence par
	public function slugStartsWith($name) {
		$this->pages = array_filter($this->pages, function($page) use ($name) {
				return Str::startsWith($page, $name);
		});

		return $this;
	}

	/// Pages dont le slug finit par
	public function slugEndsWith($name) {
		$this->pages = array_filter($this->pages, function($page) use ($name) {
				return Str::endsWith($page, $name);
		});

		return $this;
	}

	/// Pages dont le slug contient
	public function slugContains($name) {
		$this->pages = array_filter($this->pages, function($page) use ($name) {
				return Str::contains($page, $name);
		});

		return $this;
	}

	/// à faire : Pages qui contiennent le champ
	public function containsField($name) {
		$this->pages = array_filter($this->pages, function($page) use ($name) {
				return true;
		});

		return $this;
	}

	/// à faire : Pages dont le champ vaut
	public function fieldValueIs($fieldName, $fieldValue) {
		$this->pages = array_filter($this->pages, function($page) use ($name) {
				return true;
		});

		return $this;
	}

	/// Itérateur : le slug de la page en clé et la page en valeur
	public function getIterator() {
		$pages = [];

		foreach ($this->pages as $page) {
			$p = Page::getLastVersion($page);
			$pages[$page] = $p;
		}

		foreach ($pages as $slug => $page)
			yield $slug => $page;
	}

	/// Récupérer toutes les pages
	public static function allPages() {
		// Retourne les pages en cache s'il y en a
		if (static::$cacheAllPages != null)
			return static::$cacheAllPages;

		$dirs = scandir('content/pages');

		$dirs = array_filter($dirs, function($dir) {
				return ($dir != '.' && $dir != '..');
		});

		$dirs = array_values($dirs);

		$self = new static($dirs);

		// Complète le cache avec les pages récupérées
		static::$cacheAllPages = $self;

		return static::$cacheAllPages;
	}
}
