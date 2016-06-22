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

use Pi\Core\Routing\Router;
use Pi\Core\View\Renderer;
use Pi\Core\Page\PageCollection;
use Pi\Lib\Flash;
use Pi\Lib\Session;
use Pi\Lib\Twig;

class Pi {
	/** @var Renderer Moteur de rendu */
	protected $renderer;

	/** @var string */
	protected $query;

	/** @var Theme Thème */
	protected $theme;

	/** @var array Modèles enregistrés */
	protected $models;

	/** @var array Champs enregistrés */
	protected $fields;

	/** @var array Modèles enregistrés */
	protected $overridedModels;

	/** @var array Champs enregistrés */
	protected $overridedFields;

	/** @var PageCollection Pages enregistrées */
	protected $pages;

	/** @var array Utilisateurs enregistrés */
	protected $users;

	/** @var string[] Fichiers CSS enregistrés */
	protected $cssUrls;

	/** @var string[] Fichiers JavaScript enregistrés */
	protected $jsUrls;

	/** @var \stdClass Paramètres du site */
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
	 * @param $class Classe à charger
	 *
	 * @throws \Exception
	 */
	public static function autoload(string $class) {
		// S'il s'agit d'une classe sans espace de nom, elle est ignorée
		if (strpos($class, '\\') === false)
			return;

		// Espaces de nom enregistrés
		static $namespaces = [
			'Pi' => PI_DIR_SITE . 'pi/',
			'Module' => PI_DIR_MODULES,
			'Theme' => PI_DIR_THEMES
		];

		// Recherche du dossier à utiliser
		$finalNamespace = '';
		$finalDir = '';

		foreach ($namespaces as $namespace => $dir) {
			if (strpos($class, $namespace) === 0) {
				$finalNamespace = $namespace;
				$finalDir = $dir;
				break;
			}
		}

		// Aucun espace de nom trouvé
		if (!$finalNamespace)
			throw new \Exception('Unable to find a namespace for "' . $class . '"');

		// Fichier à charger
		$file = $finalDir
			. str_replace('\\', '/', substr($class, strlen($finalNamespace) + 1))
			. '.php';

		$parts = explode('/', $file);

		$i = 0;

		$newParts = [];

		foreach ($parts as $part) {
			if ($i == count($parts) - 1)
				$newParts[] = $part;
			else
				$newParts[] = strtolower($part);

			$i++;
		}

		$file = join('/', $newParts);

		// Chargement du fichier
		if (is_file($file))
			require $file;
		else
			throw new \Exception('Unable to load "' . $file . '"');
	}

	/**
	 * Contruction de l'application
	 */
	public function __construct() {
		Twig\AutoLoader::register();

		$this->fields = [];
		$this->overridedFields = [];
		$this->models = [];
		$this->overridedModels = [];
		$this->pages = PageCollection::getAllPages();
		$this->users = [];
		$this->cssUrls = [];
		$this->jsUrls = [];
		$this->settings = new \stdClass();
		$this->router = new Router();
		$this->session = new Session();
		$this->flash = new Flash();
	}

	/**
	 * Rendu du fichier
	 *
	 * @param $file
	 * @param $variables
	 *
	 * @return Rendu de la page
	 */
	public function render(string $file, array $variables = []): string {
		return $this->renderer->render($file, $variables);
	}

	/**
	 * Récupérer la liste des modèles
	 *
	 * @return Liste des modèles
	 */
	public function getModels(): array {
		return $this->models;
	}

	/**
	 * Récupérer la liste des champs
	 *
	 * @return Liste des champs
	 */
	public function getFields(): array {
		return $this->fields;
	}

	/**
	 * Récupérer la liste des pages
	 *
	 * @return Liste des pages
	 */
	public function getPages(): PageCollection {
		return $this->pages;
	}

	/**
	 * Récupérer la liste des utilisateurs
	 *
	 * @return User[]
	 */
	public function getUsers(): array {
		return $this->users;
	}

	/**
	 * Récupérer les paramètres du site
	 *
	 * @return Paramètres du site
	 */
	public function getSettings(): \stdClass {
		return $this->settings;
	}

	/**
	 * Récupérer le thème du site
	 *
	 * @return Slug du thème
	 */
	public function getTheme(): string {
		return $this->theme;
	}

	/**
	 * @param $url Fichier CSS à charger
	 */
	public function loadCss(string $url) {
		$this->cssUrls[] = $url;
	}

	/**
	 * @param $url Fichier JavaScript à charger
	 */
	public function loadJs(string $url) {
		$this->jsUrls[] = $url;
	}

	/**
	 * @return string[] Fichiers CSS
	 */
	public function getCssUrls(): array {
		return $this->cssUrls;
	}

	/**
	 * @return string[] Fichiers JavaScript
	 */
	public function getJsUrls(): array {
		return $this->jsUrls;
	}

	/**
	 * @return Chemin
	 */
	public function getPath(): string {
		return $this->router->getPath();
	}

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 *
	 * @param $modelName Nom du modèle
	 * @param $modelClass Classe du modèle
	 *
	 * @throws \Exception
	 */
	public function registerModel(string $modelName, string $modelClass) {
		if (array_key_exists($modelName, $this->models))
			throw new \Exception('Model "' . $modelName . '" already registered');

		$this->models[$modelName] = $modelClass;
	}

	/**
	 * Surcharger un modèle
	 *
	 * @param $modelName Nom du modèle à surcharger
	 * @param $modelClass Classe du modèle
	 *
	 * @throws Exception
	 */
	public function overrideModel(string $modelName, string $modelClass) {
		if (!array_key_exists($modelName, $this->models))
			throw new \Exception('Model "' . $modelName . '" does not exists and
				cannot be overrided');

		if (array_key_exists($modelName, $this->overridedModels))
			throw new \Exception('Model "' . $modelName . '" already overrided');

		$this->overridedModels[$modelName] = $modelClass;
	}

	/**
	 * @todo
	 *
	 * Surcharger la vue d'un modèle
	 *
	 * @param $modelName Nom du modèle à surcharger
	 * @param $filename Chemin vers la vue surchargée
	 *
	 * @throws \Exception
	 */
	public function overrideViewModel(string $modelName, string $filename) {
		throw new \Exception('Non-implemented');
	}

	/**
	 * Enregistrer un nouveau champ
	 *
	 * @param $fieldName Nom du champ
	 * @param $fieldClass Classe du champ
	 *
	 * @throws \Exception
	 */
	public function registerField(string $fieldName, string $fieldClass) {
		if (array_key_exists($fieldName, $this->fields))
			throw new \Exception('Field "' . $fieldName . '" already registered');

		$this->fields[$fieldName] = $fieldClass;
	}

	/**
	 * Surcharger un champ
	 *
	 * @param $fieldName Nom du champ à surcharger
	 * @param $fieldClass Classe du champ
	 *
	 * @throws \Exception
	 */
	public function overrideField(string $fieldName, string $fieldClass) {
		if (!array_key_exists($fieldName, $this->fields))
			throw new \Exception('Field "' . $fieldName . '" does not exists and
				cannot be overrided');

		if (array_key_exists($fieldName, $this->overridedFields))
			throw new \Exception('Field "' . $fieldName . '" already overrided');

		$this->overridedFields[$fieldName] = $fieldClass;
	}
}
