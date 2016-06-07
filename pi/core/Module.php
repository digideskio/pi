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

namespace Pi\Core;

abstract class Module {
	/** @var App */
	private $app;

	/**
	 * Constructeur
	 *
	 * @param App $app
	 */
	final public function __construct($app) {
		$this->app = $app;
	}

	/**
	 * Initialisation du module
	 */
	abstract public function initialize();

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	protected function registerModel($modelName, $modelClass) {
		$this->app->registerModel(
			$modelName,
			$modelClass);
	}

	/**
	 * Surcharger un modèle
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	protected function overrideModel($modelName, $fieldClass) {
		$this->app->overrideModel(
				$modelName,
				$fieldClass);
	}

	/**
	 * Surcharger la vue d'un modèle
	 *
	 * @param string $modelName Nom du modèle à surcharger
	 * @param string $filename Chemin vers la vue surchargée
	 *
	 * @throws Exception
	 */
	protected function overrideViewModel($modelName, $filename) {
		$this->app->overrideViewModel(
			$modelName,
			$filename);
	}

	/**
	 * Enregistrer un nouveau champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @throws Exception
	 */
	protected function registerField($fieldName, $fieldClass) {
		$this->app->registerField(
			$fieldName,
			$fieldClass);
	}

	/**
	 * Surcharger un champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @throws Exception
	 */
	protected function overrideField($fieldName, $fieldClass) {
		$this->app->overrideField(
			$fieldName,
			$fieldClass);
	}

	/**
	 * @param string $url
	 */
	protected function loadCss($url) {
		$this->app->loadCss($url);
	}

	/**
	 * @param string $url
	 */
	protected function loadJs($url) {
		$this->app->loadJs($url);
	}
}
