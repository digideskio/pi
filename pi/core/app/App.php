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

use Pi\Core\FileCollection\File;
use Pi\Core\Model\Field;
use Pi\Core\Model\Model;
use Pi\Core\Page\PageCollection;
use Pi\Core\Repository\PageRepository;
use Pi\Core\Routing\Router;
use Pi\Core\User\Role;
use Pi\Core\User\User;
use Pi\Core\View\Renderer;
use Pi\Lib\Flash;
use Pi\Lib\Json;
use Pi\Lib\Session;

class App extends Pi {
	/** @var array */
	private $treeThemes;

	/** @var PageRepository */
	private $pagesRepository;

	/**
	 * Contruction de l'application
	 */
	public function __construct() {
		$router = new Router();
		$session = new Session();
		$flash = new Flash($session);

		parent::__construct($router, $session, $flash);

		$this->initializeRepositories();
		$this->initializeSettings();
		$this->initializeRoles();
		$this->initializeUsers();
		$this->initializePages();
		$this->initializeTheme();
		$this->initializeRenderer();
		$this->initializeModules();
	}

	/**
	 * Initialise les paramètres
	 */
	private function initializeSettings() {
		$this->settings = Json::read(PI_DIR_CONTENT . 'settings.json');
	}

	/**
	 * Initialise les rôles
	 */
	private function initializeRoles() {
		foreach ($this->settings->roles as $slug => $role) {
			$this->roles[$slug] = new Role([
				'name' => $role->name,
				'permissions' => (array) $role->permissions
			]);
		}
	}

	/**
	 * Initialise les utilisateurs
	 */
	private function initializeUsers() {
		foreach ($this->settings->users as $username => $user) {
			$user->username = $username;
			$user->role = $this->roles[$user->role];

			$this->users[$username] = new User((array) $user);
		}
	}

	/**
	 * Initialise les pages
	 */
	private function initializePages() {
		$this->pages = new PageCollection($this->pagesRepository->getAll());

		try {
			$this->currentPage = $this
				->pagesRepository
				->getBySlug($this->router->getPath());
		} catch (\Exception $e) {
			$this->currentPage = $this
				->pagesRepository
				->getBySlug('error');
		}
	}

	/**
	 * Initialise le thème courant
	 */
	private function initializeTheme() {
		$this->treeThemes = [];

		$themeName = $this->settings->site->theme;

		if (!$themeName)
			$themeName = 'classic';

		define('PI_DIR_THEME', PI_DIR_THEMES . $themeName . '/');
		define('PI_URL_THEME', PI_URL_THEMES . $themeName . '/');

		$fileName = PI_DIR_THEME . ucfirst($themeName) . 'Theme.php';

		if (file_exists($fileName)) {
			require $fileName;

			$classname = 'Theme\\' . $themeName . '\\'
				. $themeName . 'Theme';

			/** @var Theme $theme */
			$this->theme = new $classname($this);
			$this->theme->setName($themeName);
			$this->theme->initialize();

			$reflectTheme = new \ReflectionClass($this->theme);

			$this->treeThemes[] = [
				'folder' => dirname($reflectTheme->getFileName()) . '/',
				'url' => PI_URL_THEMES
					. substr(strtolower($reflectTheme->getShortName()), 0, -5) . '/'
			];

			while ($reflectTheme = $reflectTheme->getParentClass()) {
				if ($reflectTheme->getName() != 'Pi\Core\App\Theme') {
					$this->treeThemes[] = [
						'folder' => dirname($reflectTheme->getFileName()) . '/',
						'url' => PI_URL_THEMES
							. substr(strtolower($reflectTheme->getShortName()), 0, -5) . '/'
					];
				}
			}
		} else {
			throw new \Exception('Unable to load "' . $themeName . 'Theme.php" for
				theme "' . $themeName . '"');
		}
	}

	/**
	 * Initialise le moteur de rendu
	 */
	private function initializeRenderer() {
		$this->renderer = new Renderer($this);

		foreach ($this->treeThemes as $theme)
			if (is_dir($theme['folder']))
				$this->renderer->addPath($theme['folder'], 'theme');
	}

	/**
	 * Initialisation des modules
	 */
	private function initializeModules() {
		foreach (scandir(PI_DIR_MODULES) as $dir) {
			if ($dir == '.' || $dir == '..')
				continue;

			$fileName = PI_DIR_MODULES . $dir . '/'
				. ucfirst($dir) . 'Module.php';

			if (file_exists($fileName)) {
				require $fileName;

				$classname = 'Module\\' . $dir . '\\' . $dir . 'Module';

				/** @var Module $module */
				$module = new $classname($this);
				$module->initialize();

				$this->modules[] = $module;
			} else {
				throw new \Exception('Missing "' . $dir . 'Module.php" in module
					"' . $dir . '"');
			}
		}
	}

	/**
	 * Lance la recherche de la page et la retourne
	 */
	public function run() {
		$model = $this->currentPage->getModel();
		$fields = $this->currentPage->getFields();

		/** @var Model $modelObject */
		$modelObject = $this->getModel($model);

		$meta = [
			'slug' => $this->currentPage->getSlug(),
			'title' => $this->currentPage->getTitle(),
			'model' => $model,
			'created_at' => $this->currentPage->getCreatedAt(),
			'updated_at' => $this->currentPage->getUpdatedAt()
		];

		echo $this->render($modelObject->getViewFilename(), [
			'page' => $fields,
			'meta' => $meta
		]);
	}

	private function initializeRepositories() {
		$this->pagesRepository = new PageRepository();
	}

	/**
	 * Fichiers CSS
	 */
	public function getCssUrls(): array {
		$files = [];

		foreach ($this->cssUrls as $file) {
			/** @var $file File */

			if (!$file->isAssociatedToModule()) {
				foreach ($this->treeThemes as $theme) {
					$fileName = $theme['folder'] . (string) $file;

					if (file_exists($fileName)) {
						$files[(string) $file] = $theme['url'] . $file;
						break;
					}
				}
			} else {
				foreach ($this->modules as $module) {
					$fileName = PI_DIR_MODULES . $module->getSlug() . '/' . $file;

					if (file_exists($fileName))
						$files[(string) $file] = PI_URL_MODULES . $module->getSlug() . '/' . $file;
				}
			}
		}

		foreach ($this->cssUrls as $file) {
			if (!in_array($file, array_keys($files)))
				throw new \Exception('Unable to load CSS "' . $file . '"');
		}

		return $files;
	}

	/**
	 * @todo Répétition avec le code de chargement CSS
	 *
	 * Fichiers JavaScript
	 */
	public function getJsUrls(): array {
		$files = [];

		foreach ($this->jsUrls as $file) {
			/** @var $file File */

			if (!$file->isAssociatedToModule()) {
				foreach ($this->treeThemes as $theme) {
					$fileName = $theme['folder'] . (string) $file;

					if (file_exists($fileName)) {
						$files[(string) $file] = $theme['url'] . $file;
						break;
					}
				}
			} else {
				foreach ($this->modules as $module) {
					$fileName = PI_DIR_MODULES . $module->getSlug() . '/' . $file;

					if (file_exists($fileName))
						$files[(string) $file] = PI_URL_MODULES . $module->getSlug() . '/' . $file;
				}
			}
		}

		foreach ($this->jsUrls as $file) {
			if (!in_array($file, array_keys($files)))
				throw new \Exception('Unable to load theme JS "' . $file . '"');
		}

		return $files;
	}

	/**
	 * @todo
	 *
	 * Créer un nouveau champ
	 */
	protected function newField(string $fieldName): Field {
		if ($field_does_not_exists)
			throw new \Exception('Field "' . $fieldName . '" does not exists.');

		return null;
	}

	/**
	 * Variables globales qui seront envoyées à toutes les vues
	 */
	public function getVariables(): array {
		return [
			'settings' => $this->getSettings(),

			'url' => [
				'site' => PI_URL_SITE,
				'content' => PI_URL_CONTENT,
				'pages' => PI_URL_PAGES,
				'themes' => PI_URL_THEMES,
				'theme' => PI_URL_THEME,
				'curent' => $this->getPath()
			],

			'dir' => [
				'site' => PI_DIR_SITE,
				'content' => PI_DIR_CONTENT,
				'pages' => PI_DIR_PAGES,
				'themes' => PI_DIR_THEMES,
				'theme' => PI_DIR_THEME
			],

			'jsUrls' => $this->getJsUrls(),
			'cssUrls' => $this->getCssUrls(),

			'pages' => $this->getPages(),
			'users' => $this->getUsers()
		];
	}

	/**
	 * Récupérer la racine du site
	 */
	public function getRoot(): string {
		return PI_DIR_SITE;
	}

	/**
	 * @todo Avoir plus d'informations à propos du thème, pas seulement son slug
	 *
	 * Récupérer la liste des thèmes
	 */
	public function getThemes(): array {
		$scan = scandir(PI_DIR_THEMES);

		$dirs = [];

		foreach ($scan as $dir) {
			if (is_dir($dir))
				$dirs[$dir] = $dir;
		}

		return $dirs;
	}

	/**
	 * Gestionnaire des pages
	 */
	public function getPagesRepository(): PageRepository {
		return $this->pagesRepository;
	}
}
