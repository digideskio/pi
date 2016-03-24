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

	private function __construct($pages) {
		// Récupération des pages passées en paramètre
		$this->pages = $pages;

		// Toutes les pages sont gardées excepté la page « error »
		$this->pages = array_filter($this->pages, function($slug) {
			return $slug != 'error';
		}, ARRAY_FILTER_USE_KEY);
	}

	/// Pages dont le slug commence par
	public function slugStartsWith($name) {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
      return Str::startsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/// Pages dont le slug finit par
	public function slugEndsWith($name) {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
      return Str::endsWith($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/// Pages dont le slug contient
	public function slugContains($name) {
		$this->pages = array_filter($this->pages, function($slug) use ($name) {
      return Str::contains($slug, $name);
		}, ARRAY_FILTER_USE_KEY);

		return $this;
	}

	/// Pages qui contiennent le champ
	public function containsField($fieldName) {
		$this->pages = array_filter($this->pages, function($page) use ($fieldName) {
      return isset($page['fields'][$fieldName]);
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

	/// Pages dont le modèle est
	public function withModel($modelName) {
		$this->pages = array_filter($this->pages, function($page) use ($modelName) {
      return $page['model'] == $modelName;
		});

		return $this;
	}

	/// Itérateur : le slug de la page en clé et la page en valeur
	public function getIterator() {
		foreach ($this->pages as $slug => $page)
			yield $slug => $page;
	}

	/// Récupérer toutes les pages
	public static function getAllPages() {
		// Retourne les pages en cache s'il y en a
		if (static::$cacheAllPages != null)
			return static::$cacheAllPages;

    // Récupère tous les chemins du dossier des pages
		$dirs = scandir('content/pages');

    // Supprime les chemins « . » et « .. »
		$dirs = array_filter($dirs, function($dir) {
				return ($dir != '.' && $dir != '..');
		});

    // Redéfinition de l'indexation du tableau
		$dirs = array_values($dirs);

    // Récupération de la dernière version de chacune des pages
    $pages = [];

    foreach ($dirs as $dir)
      $pages[$dir] = Page::getLastVersion($dir);

    // Création de la collection
		$self = new static($pages);

		// Complète le cache avec les pages récupérées
		static::$cacheAllPages = $self;

    // Retourne la version désormais en cache
		return static::$cacheAllPages;
	}
}
