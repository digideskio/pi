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

use Pi\Model\Form;
use Pi\Model\Model;
use Pi\Page\Page;
use Pi\Render\Renderer;

class App extends Pi {
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
	protected function initializeSettings() {
		$this->settings->load(PI_DIR_CONTENT . 'settings.json');
	}

	/**
	 * Initialise le thème courant
	 */
	protected function initializeTheme() {
		$this->theme = $this->settings->get('site.theme');

		if (!$this->theme)
			$this->theme = 'classic';

		define('PI_DIR_THEME', PI_DIR_THEMES . $this->theme . DS);
		define('PI_URL_THEME', PI_URL_THEMES . $this->theme . '/');

		if (file_exists(PI_DIR_THEME . $this->theme . '.php'))
			require PI_DIR_THEME . $this->theme . '.php';
		else
			throw new Exception('Unable to load "' . $this->theme . '.php" for
				theme "' . $this->theme . '"');
	}

	/**
	 * Initilise le moteur de rendu
	 */
	protected function initializeRenderer() {
		$this->renderer = new Renderer($this);
		$this->renderer->addPath(PI_DIR_THEME . '/tpl');
	}

	/**
	 * Initialisation des modules
	 */
	protected function initializeModules() {
		foreach (scandir(PI_DIR_MODULES) as $dir) {
			if ($dir == '.' || $dir == '..')
				continue;

			$filename = PI_DIR_MODULES . $dir . DS . 'module.php';

			if (file_exists($filename))
				require $filename;
			/*
			else
				throw new Exception('Missing "module.php" in module "'
					. $dir . '"');
			*/
		}
	}

	/**
	 * Lance la recherche de la page et la retourne
	 */
	public function run() {
		$content = Page::getLastVersion($this->router->getPath());

		if (!$content)
			$content = Page::getLastVersion('error');

		$model = $content->getModel();
		$fields = $content->getFields();

		$meta = [
			'title' => $content->getTitle(),
			'model' => $model,
			'created_at' => $content->getCreatedAt(),
			'updated_at' => $content->getUpdatedAt()
		];

		echo $this->render($model . '/view.html', [
			'page' => $fields,
			'meta' => $meta
		]);
	}
}
