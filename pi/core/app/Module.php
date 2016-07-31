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

namespace Pi\Core\App;

use Pi\Core\Page\Page;

abstract class Module {
	/** @var App */
	private $app;

	/** @var string */
	private $name;

	/** @var string */
	private $version;

	/** @var string */
	private $description;

	/** @var string */
	private $author;

	/**
	 * Constructeur
	 */
	final public function __construct(App $app) {
		$this->app = $app;
	}

	/**
	 * Initialisation du module
	 */
	abstract public function initialize();

	/**
	 * Définir le nom du module
	 */
	public function setName(string $name): Module {
		$this->name = $name;

		return $this;
	}

	/**
	 * Définir la version du module
	 */
	public function setVersion(string $version): Module {
		$this->version = $version;

		return $this;
	}

	/**
	 * Définir la description du module
	 */
	public function setDescription(string $description): Module {
		$this->description = $description;

		return $this;
	}

	/**
	 * Définir l'auteur du module
	 */
	public function setAuthor(string $author): Module {
		$this->author = $author;

		return $this;
	}

	/**
	 * Récupérer le nom du module
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Récupérer la version du module
	 */
	public function getVersion(): string {
		return $this->version;
	}

	/**
	 * Récupérer la description du module
	 */
	public function getDescription(): string {
		return $this->description;
	}

	/**
	 * Récupérer l'auteur du module
	 */
	public function getAuthor(): string {
		return $this->author;
	}

	/**
	 * Récupérer le slug du module (par ex. « TestModule » => « test »)
	 */
	public function getSlug(): string {
		$className = static::class;

		$parts = explode('\\', $className);

		$slug = array_pop($parts);
		$slug = preg_replace('/Module$/', '', $slug);
		$slug = strtolower($slug);

		return $slug;
	}

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 */
	protected function registerModel(string $modelName, string $modelClass) {
		$this->app->registerModel(
			$modelName,
			$modelClass);
	}

	/**
	 * Surcharger un modèle
	 */
	protected function overrideModel(string $modelName, string $fieldClass) {
		$this->app->overrideModel($modelName, $fieldClass);
	}

	/**
	 * Surcharger la vue d'un modèle
	 */
	protected function overrideViewModel(string $modelName, string $fileName) {
		$this->app->overrideViewModel($modelName, $fileName);
	}

	/**
	 * Enregistrer un nouveau champ
	 */
	protected function registerField(string $fieldName, string $fieldClass) {
		$this->app->registerField($fieldName, $fieldClass);
	}

	/**
	 * Surcharger un champ
	 */
	protected function overrideField(string $fieldName, string $fieldClass) {
		$this->app->overrideField($fieldName, $fieldClass);
	}

	/**
	 * Charger un fichier CSS dans le thème
	 */
	protected function registerCss(string $url) {
		$this->app->registerCss($url, $this);
	}

	/**
	 * Charger un fichier JavaScript dans le thème
	 */
	protected function registerJs(string $url) {
		$this->app->registerJs($url);
	}

	/**
	 * Décharger un fichier CSS dans le thème
	 */
	protected function unregisterCss(string $url) {
		$this->app->unregisterCss($url);
	}

	/**
	 * Décharger un fichier JavaScript dans le thème
	 */
	protected function unregisterJs(string $url) {
		$this->app->unregisterJs($url);
	}

	/**
	 * Récupérer la page courange
	 */
	protected function getCurrentPage(): Page {
		return $this->app->getCurrentPage();
	}
}
