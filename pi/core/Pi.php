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

use Exception;

use Pi\Lib\Flash;
use Pi\Lib\Json;
use Pi\Lib\Session;

class Pi {
	/** @var Renderer Moteur de rendu */
	protected $renderer;

	/** @var string */
	protected $query;

	/** @var string Nom du thème */
	protected $theme;

	/** @var array Modèles enregistrés */
	protected $models;

	/** @var array Champs enregistrés */
	protected $fields;

	/** @var array Modèles enregistrés */
	protected $overridedModels;

	/** @var array Champs enregistrés */
	protected $overridedFields;

	/** @var array Pages enregistrées */
	protected $pages;

	/** @var array Utilisateurs enregistrés */
	protected $users;

	/** @var string[] Fichiers CSS enregistrés */
	protected $cssUrls;

	/** @var string[] Fichiers JavaScript enregistrés */
	protected $jsUrls;

	/** @var array Paramètres du site */
	protected $settings;

	/** @var Router Routeur */
	protected $router;

	/** @var Session Gestionnaire de session */
	protected $session;

	/** @var Flash Gestionnaire des messages flash */
	protected $flash;

	/**
	 * Enregistre l'« autoloader »
	 */
	public static function register() {
		spl_autoload_register([ __CLASS__, 'autoload' ]);
	}

	/**
	 * Quand l'utilisation d'une classe est repérée, le fichier créant la
	 * classe est chargé
	 *
	 * @param string $class
	 *
	 * @throws Exception
	 */
	public static function autoload($class) {
		if (strpos($class, 'Pi') !== 0
			&& strpos($class, 'Module') !== 0
			&& strpos($class, 'Theme') !== 0
		)
			throw new Exception('Namespace should starts with "Pi", "Module"
				or "Theme"');

		$parts = explode('\\', $class);

		$newParts = [];

		for ($i = 0, $len = count($parts) ; $i < $len ; $i++) {
			if ($i == count($parts) - 1)
				$newParts[] = $parts[$i];
			else
				$newParts[] = strtolower($parts[$i]);
		}

		$fileName = implode('/', $newParts);

		$firstPart = $parts[0];

		if ($firstPart == 'Pi') {
			$file = realpath(__DIR__ . '/../../') . '/' . $fileName . '.php';
		} else if ($firstPart == 'Module') {
			// remplace « module » par « content/modules » (seulement la
			// première occurence)
			$pos = strpos($fileName, 'module');

			if ($pos !== false) {
				$fileName = substr_replace($fileName, 'content/modules', $pos,
					strlen('module'));
			}

			$file = realpath(__DIR__ . '/../../') . '/'
				. $fileName . '.php';
		} else if ($firstPart == 'Theme') {
			// remplace « theme » par « content/theme » (seulement la
			// première occurence)
			$pos = strpos($fileName, 'theme');

			if ($pos !== false) {
				$fileName = substr_replace($fileName, 'content/themes', $pos,
					strlen('theme'));
			}

			$file = realpath(__DIR__ . '/../../') . '/'
				. $fileName . '.php';
		} else {
			throw new Exception('Unable to load class "' . $class . '"');
		}

		if (is_file($file))
			require $file;
		else
			throw new Exception('Unable to load "' . $file . '"');
	}

	/**
	 * Contruction de l'application
	 */
	public function __construct() {
		$this->fields = [];
		$this->overridedFields = [];
		$this->models = [];
		$this->overridedModels = [];
		$this->pages = [];
		$this->users = [];
		$this->cssUrls = [];
		$this->jsUrls = [];
		$this->settings = [];
		$this->router = new Router();
		$this->session = new Session();
		$this->flash = new Flash();
	}

	/**
	 * Rendu du fichier
	 *
	 * @param string $file
	 * @param array $variables
	 *
	 * @return string
	 */
	public function render($file, $variables = []) {
		return $this->renderer->render($file, $variables);
	}

	/**
	 * Récupérer la liste des modèles
	 *
	 * @return array
	 */
	public function getModels() {
		return $this->models;
	}

	/**
	 * Récupérer la liste des champs
	 *
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Récupérer la liste des pages
	 *
	 * @return array
	 */
	public function getPages() {
		return $this->pages;
	}

	/**
	 * Récupérer la liste des utilisateurs
	 *
	 * @return array
	 */
	public function getUsers() {
		return $this->users;
	}

	/**
	 * Récupérer les paramètres du site
	 *
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}

	/**
	 * Récupérer le thème du site
	 *
	 * @return string
	 */
	public function getTheme() {
		return $this->theme;
	}

	/**
	 * @param string $url
	 */
	public function loadCss($url) {
		$this->cssUrls[] = $url;
	}

	/**
	 * @param string $url
	 */
	public function loadJs($url) {
		$this->jsUrls[] = $url;
	}

	/**
	 * @return string[]
	 */
	public function getCssUrls() {
		return $this->cssUrls;
	}

	/**
	 * @return string[]
	 */
	public function getJsUrls() {
		return $this->jsUrls;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->router->getPath();
	}

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	public function registerModel($modelName, $modelClass) {
		if (array_key_exists($modelName, $this->models))
			throw new Exception('Model "' . $modelName . '" already registered');

		$this->models[$modelName] = $modelClass;
	}

	/**
	 * Surcharger un modèle
	 *
	 * @param string $modelName Nom du modèle à surcharger
	 * @param string $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	public function overrideModel($modelName, $modelClass) {
		if (!array_key_exists($modelName, $this->models))
			throw new Exception('Model "' . $modelName . '" does not exists and
				cannot be overrided');

		if (array_key_exists($modelName, $this->overridedModels))
			throw new Exception('Model "' . $modelName . '" already overrided');

		$this->overridedModels[$modelName] = $modelClass;
	}

	/**
	 * @todo
	 *
	 * Surcharger la vue d'un modèle
	 *
	 * @param string $modelName Nom du modèle à surcharger
	 * @param string $filename Chemin vers la vue surchargée
	 *
	 * @throws Exception
	 */
	public function overrideViewModel($modelName, $filename) {
		throw new Exception('Non-implemented');
	}

	/**
	 * Enregistrer un nouveau champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @throws Exception
	 */
	public function registerField($fieldName, $fieldClass) {
		if (array_key_exists($fieldName, $this->fields))
			throw new Exception('Field "' . $fieldName . '" already registered');

		$this->fields[$fieldName] = $fieldClass;
	}

	/**
	 * Surcharger un champ
	 *
	 * @param string $fieldName Nom du champ à surcharger
	 * @param string $fieldClass Classe du champ
	 *
	 * @throws Exception
	 */
	public function overrideField($fieldName, $fieldClass) {
		if (!array_key_exists($fieldName, $this->fields))
			throw new Exception('Field "' . $fieldName . '" does not exists and
				cannot be overrided');

		if (array_key_exists($fieldName, $this->overridedFields))
			throw new Exception('Field "' . $fieldName . '" already overrided');

		$this->overridedFields[$fieldName] = $fieldClass;
	}
}
