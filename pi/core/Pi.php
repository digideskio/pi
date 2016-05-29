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
use Pi\Model\Model;
use Pi\Render\Renderer;

class Pi {
	/** @var Renderer */
	protected $renderer;

	/** @var string */
	protected $query;

	/** @var string */
	protected $theme;

	/** @var array */
	protected $models;

	/** @var array */
	protected $fields;

	/** @var array */
	protected $pages;

	/** @var array */
	protected $users;

	/** @var string[] */
	protected $cssUrls;

	/** @var string[] */
	protected $jsUrls;

	/** @var Settings */
	protected $settings;

	/** @var Router */
	protected $router;

	/** @var Session */
	protected $session;

	/** @var Flash */
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

		$fileName = implode(DS, $newParts);

		$firstPart = $parts[0];

		if ($firstPart == 'Pi') {
			$file = realpath(__DIR__ . '/../../') . DS . $fileName . '.php';
		} else if ($firstPart == 'Module') {
			// remplace « module » par « content/modules » (seulement la
			// première occurence)
			$pos = strpos($fileName, 'module');

			if ($pos !== false) {
				$fileName = substr_replace($fileName, 'content/modules', $pos,
					strlen('module'));
			}

			$file = realpath(__DIR__ . '/../../') . DS
				. $fileName . '.php';
		} else if ($firstPart == 'Theme') {
			// remplace « theme » par « content/theme » (seulement la
			// première occurence)
			$pos = strpos($fileName, 'theme');

			if ($pos !== false) {
				$fileName = substr_replace($fileName, 'content/themes', $pos,
					strlen('theme'));
			}

			$file = realpath(__DIR__ . '/../../') . DS
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
		$this->models = [];
		$this->pages = [];
		$this->users = [];
		$this->cssUrls = [];
		$this->jsUrls = [];
		$this->settings = new Settings();
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
	 * @return Settings
	 */
	public function getSettings() {
		return $this->settings->getSettings();
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
		$this->models[$modelName] = new Model(
			$modelName,
			$modelFilename,
			$viewFilename);

		$model = Json::read($modelFilename);

		$modelClass = new class($viewFilename) extends Model {
			public function __construct($viewFilename) {
				parent::__construct();

				$this->setTitle('Test');
				$this->setViewFilename($viewFilename);
			}
		};

		$this->models[] = $modelClass;

		return true;
	}

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelClass Classe du modèle
	 *
	 * @return bool true si le modèle a pu être enregistré, false sinon
	 */
	public function registerModelFromClass($modelName, $modelClass) {
		$this->models[$modelName] = $modelClass;

		return true;
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
		$this->fields[$fieldName] = $fieldClass;

		return true;
	}

	/**
	 * @todo
	 *
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
		return true;
	}

	/**
	 * @todo
	 *
	 * Surcharger la vue d'un modèle
	 *
	 * @param string $modelName Nom du modèle à surcharger
	 * @param string $filename Chemin vers la vue surchargée
	 *
	 * @return bool true si la vue a pu être surchargée, false sinon
	 */
	public function overrideViewModel($modelName, $filename) {
		return true;
	}

	/**
	 * @todo
	 *
	 * Surcharger un champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @return bool true si la vue a pu être surchargée, false sinon
	 */
	public function overrideField($fieldName, $fieldClass) {
		return true;
	}
}
