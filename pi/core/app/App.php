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

use Pi\Core\Model\Model;
use Pi\Core\Page\Page;
use Pi\Core\View\Renderer;
use Pi\Lib\Json;

class App extends Pi {
	private $foldersThemes;

	/**
	 * Contruction de l'application
	 */
	public function __construct() {
		parent::__construct();

		$this->initializeSettings();
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
	 * Initialise le thème courant
	 */
	private function initializeTheme() {
		$this->foldersThemes = [];

		$themeName = $this->settings->site->theme;

		if (!$themeName)
			$themeName = 'classic';

		define('PI_DIR_THEME', PI_DIR_THEMES . $themeName . '/');
		define('PI_URL_THEME', PI_URL_THEMES . $themeName . '/');

		$filename = PI_DIR_THEME . ucfirst($themeName) . 'Theme.php';

		if (file_exists($filename)) {
			require $filename;

			$classname = 'Theme\\' . $themeName . '\\'
				. $themeName . 'Theme';

			/** @var Theme $theme */
			$this->theme = new $classname($this);
			$this->theme->setName($themeName);
			$this->theme->initialize();

			$reflectTheme = new \ReflectionClass($this->theme);

			$this->foldersThemes[] = dirname($reflectTheme->getFileName()). '/tpl/';

			while ($reflectTheme = $reflectTheme->getParentClass())
				if ($reflectTheme->getName() != 'Pi\Core\App\Theme')
					$this->foldersThemes[] = dirname($reflectTheme->getFileName()) . '/tpl/';
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

		foreach ($this->foldersThemes as $folderTheme)
			if (is_dir($folderTheme))
				$this->renderer->addPath($folderTheme, 'theme');
	}

	/**
	 * Initialisation des modules
	 */
	private function initializeModules() {
		foreach (scandir(PI_DIR_MODULES) as $dir) {
			if ($dir == '.' || $dir == '..')
				continue;

			$filename = PI_DIR_MODULES . $dir . '/'
				. ucfirst($dir) . 'Module.php';

			if (file_exists($filename)) {
				require $filename;

				$classname = 'Module\\' . $dir . '\\' . $dir . 'Module';

				/** @var Module $module */
				$module = new $classname($this);
				$module->initialize();
			} else {
				throw new \Exception('Missing "' . $dir . 'Module.php" in module
					"' . $dir . '"');
			}
		}
	}

	/**
	 * @todo
	 *
	 * Lance la recherche de la page et la retourne
	 */
	public function run() {
		try {
			$content = Page::getLastVersion($this->router->getPath());
		} catch (\Exception $e) {
			$content = Page::getLastVersion('error');
		}

		$model = $content->getModel();
		$fields = $content->getFields();

		/** @var Model $modelObject */
		$modelObject = new $this->models[$model]();

		$meta = [
			'title' => $content->getTitle(),
			'model' => $model,
			'created_at' => $content->getCreatedAt(),
			'updated_at' => $content->getUpdatedAt()
		];

		echo $this->render($modelObject->getViewFilename(), [
			'page' => $fields,
			'meta' => $meta
		]);
	}
}
