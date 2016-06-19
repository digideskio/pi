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

abstract class Module {
	/** @var App */
	private $app;

	/**
	 * Constructeur
	 *
	 * @param $app Application
	 */
	final public function __construct(App $app) {
		$this->app = $app;
	}

	/**
	 * Initialisation du module
	 */
	abstract public function initialize();

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 *
	 * @param $modelName Nom du modèle
	 * @param $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	protected function registerModel(string $modelName, string $modelClass) {
		$this->app->registerModel(
			$modelName,
			$modelClass);
	}

	/**
	 * Surcharger un modèle
	 *
	 * @param $modelName Nom du modèle
	 * @param $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	protected function overrideModel(string $modelName, string $fieldClass) {
		$this->app->overrideModel(
				$modelName,
				$fieldClass);
	}

	/**
	 * Surcharger la vue d'un modèle
	 *
	 * @param $modelName Nom du modèle à surcharger
	 * @param $filename Chemin vers la vue surchargée
	 *
	 * @throws Exception
	 */
	protected function overrideViewModel(string $modelName, string $filename) {
		$this->app->overrideViewModel(
			$modelName,
			$filename);
	}

	/**
	 * Enregistrer un nouveau champ
	 *
	 * @param $fieldName Nom du champ
	 * @param $fieldClass Classe du champ
	 *
	 * @throws Exception
	 */
	protected function registerField(string $fieldName, string $fieldClass) {
		$this->app->registerField($fieldName, $fieldClass);
	}

	/**
	 * Surcharger un champ
	 *
	 * @param $fieldName Nom du champ
	 * @param $fieldClass Classe du champ
	 *
	 * @throws Exception
	 */
	protected function overrideField(string $fieldName, string $fieldClass) {
		$this->app->overrideField($fieldName, $fieldClass);
	}

	/**
	 * @param $url
	 */
	protected function loadCss(string $url) {
		$this->app->loadCss($url);
	}

	/**
	 * @param $url
	 */
	protected function loadJs(string $url) {
		$this->app->loadJs($url);
	}
}
