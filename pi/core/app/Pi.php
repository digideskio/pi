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

use Pi\Core\FileCollection\FileCollection;
use Pi\Core\Model\Field;
use Pi\Core\Model\Model;
use Pi\Core\Page\Page;
use Pi\Core\Routing\Router;
use Pi\Core\User\Role;
use Pi\Core\User\User;
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

	/** @var Module[] Modules chargés */
	protected $modules;

	/** @var Model[] Modèles enregistrés */
	protected $models;

	/** @var Field[] Champs enregistrés */
	protected $fields;

	/** @var array Modèles enregistrés */
	protected $overridedModels;

	/** @var array Champs enregistrés */
	protected $overridedFields;

	/** @var Page Page courante */
	protected $currentPage;

	/** @var PageCollection Pages enregistrées */
	protected $pages;

	/** @var Role[] Rôles enregistrés */
	protected $roles;

	/** @var User[] Utilisateurs enregistrés */
	protected $users;

	/** @var FileCollection Fichiers CSS enregistrés */
	protected $cssUrls;

	/** @var FileCollection Fichiers JavaScript enregistrés */
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
	 * @todo Sortir la création des instances de FileCollection d'ici
	 *
	 * Contruction de l'application
	 */
	public function __construct(Router $router,
	                            Session $session,
	                            Flash $flash) {
		Twig\AutoLoader::register();

		$this->modules = [];
		$this->fields = [];
		$this->overridedFields = [];
		$this->models = [];
		$this->overridedModels = [];
		$this->pages = null;
		$this->roles = [];
		$this->users = [];
		$this->cssUrls = new FileCollection();
		$this->jsUrls = new FileCollection();
		$this->settings = new \stdClass();
		$this->router = $router;
		$this->session = $session;
		$this->flash = $flash;
	}

	/**
	 * Rendu du fichier
	 */
	public function render(string $file, array $variables = []): string {
		return $this->renderer->render($file, $variables);
	}

	/**
	 * Récupérer la liste des modèles
	 */
	public function getModels(): array {
		return $this->models;
	}

	/**
	 * Récupérer la liste des champs
	 */
	public function getFields(): array {
		return $this->fields;
	}

	/**
	 * Récupérer la page courante
	 */
	public function getCurrentPage(): Page {
		return $this->currentPage;
	}

	/**
	 * Récupérer la liste des pages
	 */
	public function getPages(): PageCollection {
		return $this->pages;
	}

	/**
	 * Récupérer la liste des rôles
	 */
	public function getRoles(): array {
		return $this->roles;
	}

	/**
	 * Récupérer la liste des utilisateurs
	 */
	public function getUsers(): array {
		return $this->users;
	}

	/**
	 * Récupérer les paramètres du site
	 */
	public function getSettings(): \stdClass {
		return $this->settings;
	}

	/**
	 * Récupérer le thème du site
	 */
	public function getTheme(): string {
		return $this->theme;
	}

	/**
	 * Récupérer la liste des utilisateurs
	 */
	public function getUser(string $username): User {
		if (!array_key_exists($username, $this->users))
			throw new \Exception('User "' . $username . '" does not exists.');

		return $this->users[$username];
	}

	/**
	 * Enregistrer un fichier CSS
	 */
	public function registerCss(string $url, Module $module = null) {
		if ($this->cssUrls->hasFile($url))
			throw new \Exception('Try to load an already loaded CSS "'
				. $url . '"');

		$this->cssUrls->addFile($url, $module);
	}

	/**
	 * Enregistrer un fichier JS
	 */
	public function registerJs(string $url) {
		if (in_array($url, $this->jsUrls))
			throw new \Exception('Try to load an already loaded JS "'
				. $url . '"');

		$this->jsUrls[] = $url;
	}

	/**
	 * Désenregistrer un fichier CSS
	 */
	public function unregisterCss(string $url) {
		foreach ($this->cssUrls as $key => $cssUrl) {
			if ($url == $cssUrl) {
				unset($this->cssUrls[$key]);

				return;
			}
		}

		throw new \Exception('Try to unregister a non-loaded CSS file "'
			. $url . '"');
	}

	/**
	 * Désenregistrer un fichier JS
	 */
	public function unregisterJs(string $url) {
		foreach ($this->jsUrls as $key => $jsUrl) {
			if ($url == $jsUrl) {
				unset($this->jsUrls[$key]);

				return;
			}
		}

		throw new \Exception('Try to unregister a non-loaded JS file "'
			. $url . '"');	}

	/**
	 * Récupérer la liste des fichiers CSS
	 */
	public function getCssUrls(): array {
		return $this->cssUrls;
	}

	/**
	 * Récupérer la liste des fichiers JavaScript
	 */
	public function getJsUrls(): array {
		return $this->jsUrls;
	}

	/**
	 * Récupérer le chemin
	 */
	public function getPath(): string {
		return $this->router->getPath();
	}

	/**
	 * Enregistrer un nouveau modèle depuis une classe
	 */
	public function registerModel(string $modelName, string $modelClass) {
		if (array_key_exists($modelName, $this->models))
			throw new \Exception('Model "' . $modelName . '" already registered');

		$this->models[$modelName] = new $modelClass($this);
	}

	/**
	 * Surcharger un modèle
	 */
	public function overrideModel(string $modelName, string $modelClass) {
		if (!array_key_exists($modelName, $this->models))
			throw new \Exception('Model "' . $modelName . '" does not exists and
				cannot be overrided');

		if (array_key_exists($modelName, $this->overridedModels))
			throw new \Exception('Model "' . $modelName . '" already overrided');

		$this->overridedModels[$modelName] = new $modelClass();
	}

	/**
	 * Surcharger la vue d'un modèle
	 */
	public function overrideViewModel(string $modelName, string $fileName) {
		if (!array_key_exists($modelName, $this->models))
			throw new \Exception('Unable to override the view of an unexisting'
				. ' model "' . $modelName . '"');

		if (!file_exists($fileName))
			throw new \Exception('The overrided-model-view file does not exists'
				. ' "' . $fileName . '"');

		/** @var Model $model */
		$model = $this->models[$modelName];
		$model->setViewFilename($fileName);
	}

	/**
	 * Enregistrer un nouveau champ
	 */
	public function registerField(string $fieldName, string $fieldClass) {
		if (array_key_exists($fieldName, $this->fields))
			throw new \Exception('Field "' . $fieldName . '" already registered');

		$this->fields[$fieldName] = $fieldClass;
	}

	/**
	 * Surcharger un champ
	 */
	public function overrideField(string $fieldName, string $fieldClass) {
		if (!array_key_exists($fieldName, $this->fields))
			throw new \Exception('Field "' . $fieldName . '" does not exists and
				cannot be overrided');

		if (array_key_exists($fieldName, $this->overridedFields))
			throw new \Exception('Field "' . $fieldName . '" already overrided');

		$this->overridedFields[$fieldName] = $fieldClass;
	}

	/**
	 * Récupérer un champ
	 */
	public function getField(string $fieldName): Field {
		if (array_key_exists($fieldName, $this->overridedFields))
			return new $this->overridedFields[$fieldName];

		if (array_key_exists($fieldName, $this->fields))
			return new $this->fields[$fieldName];

		throw new \Exception('Field "' . $fieldName . '" does not exists');
	}

	/**
	 * Récupérer un modèle
	 */
	public function getModel(string $modelName): Model {
		if (array_key_exists($modelName, $this->overridedModels))
			return $this->overridedModels[$modelName];

		if (array_key_exists($modelName, $this->models))
			return $this->models[$modelName];

		throw new \Exception('Model "' . $modelName . '" does not exists');
	}
}
