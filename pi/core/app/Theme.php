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

abstract class Theme {
	/** @var App */
	private $app;

	/** @var string Nom du thème */
	private $name;

	/**
	 * Constructeur du thème
	 *
	 * @param $app Application
	 */
	final public function __construct(App $app) {
		$this->app = $app;
	}

	/**
	 * Initialisation du thème
	 */
	abstract public function initialize();

	/**
	 * Définir le nom du thème
	 *
	 * @param $themeName Nom du thème
	 *
	 * @return $this L'instance du thème
	 */
	public function setName(string $themeName): Theme {
		$this->name = $themeName;

		return $this;
	}

	/**
	 * Charger un fichier CSS dans le thème
	 *
	 * @param $url Chemin vers le fichier CSS à charger
	 */
	protected function loadCss(string $url) {
		$this->app->loadCss($url);
	}

	/**
	 * Charger un fichier JavaScript dans le thème
	 *
	 * @param $url Chemin vers le fichier JavaScript à charger
	 */
	protected function loadJs(string $url) {
		$this->app->loadJs($url);
	}

	/**
	 * Surcharger la vue d'un modèle
	 *
	 * @param $modelName Nom du modèle dont la vue doit être surchargée
	 * @param $filename Chemin vers la vue surchargée
	 *
	 * @throws Exception
	 */
	protected function overrideViewModel(string $modelName, string $filename) {
		$this->app->overrideViewModel($modelName, $filename);
	}
}
