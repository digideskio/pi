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

abstract class Theme {
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
	 * Initialisation du thème
	 */
	abstract public function initialize();

	/**
	 * Charger un fichier CSS dans le thème
	 *
	 * @param string $url
	 */
	public function loadCss($url) {
		$this->app->loadCss($url);
	}

	/**
	 * Charger un fichier JavaScript dans le thème
	 *
	 * @param string $url
	 */
	public function loadJs($url) {
		$this->app->loadJs($url);
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
}
