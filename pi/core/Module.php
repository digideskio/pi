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
	protected $app;

	/**
	 * Constructeur
	 *
	 * @param App $app
	 */
	public final function __construct($app) {
		$this->app = $app;
	}

	/**
	 * Initialisation du module
	 */
	abstract public function initialize();

	/**
	 * Enregistrer un nouveau modèle
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelFilename Chemin vers le fichier modèle (JSON)
	 * @param string $viewFilename Chemin vers le fichier vue (Twig)
	 *
	 * @return bool true si le modèle a pu être enregistré, false sinon
	 */
	public function registerModel($modelName, $modelFilename = null,
	                              $viewFilename = null) {
		return $this->app->registerModel(
			$modelName,
			$modelFilename,
			$viewFilename);
	}

	/**
	 * Enregistrer un nouveau modèle depuis une class
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelClass Classe du modèle
	 *
	 * @return bool true si le modèle a pu être enregistré, false sinon
	 */
	public function registerModelFromClass($modelName, $modelClass) {
		return $this->app->registerModelFromClass(
			$modelName,
			$modelClass);
	}

	/**
	 * Enregistrer un nouveau champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @return bool true si le champ a pu être enregistré, false sinon
	 */
	public function registerField($fieldName, $fieldClass) {
		return $this->app->registerField(
			$fieldName,
			$fieldClass);
	}

	/**
	 * Surcharger un modèle
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelFilename Chemin vers le fichier modèle (JSON)
	 * @param string $viewFilename Chemin vers le fichier vue (Twig)
	 *
	 * @return bool true si le modèle a pu être surchargé, false sinon
	 */
	public function overrideModel($modelName, $modelFilename,
	                              $viewFilename) {
		return $this->app->overrideModel(
				$modelName,
				$modelFilename,
				$viewFilename);
	}

	/**
	 * Surcharger la vue d'un modèle
	 *
	 * @param string $modelName Nom du modèle à surcharger
	 * @param string $filename Chemin vers la vue surchargée
	 *
	 * @return bool true si la vue a pu être surchargée, false sinon
	 */
	public function overrideViewModel($modelName, $filename) {
		return $this->app->overrideViewModel(
			$modelName,
			$filename);
	}

	/**
	 * Surcharger un champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @return bool true si la vue a pu être surchargée, false sinon
	 */
	public function overrideField($fieldName, $fieldClass) {
		return $this->app->overrideField(
			$fieldName,
			$fieldClass);
	}
}
