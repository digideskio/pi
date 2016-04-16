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

namespace Pi;

use Exception;

use Pi\Core\Form;
use Pi\Core\Model;
use Pi\Core\Page;
use Pi\Core\Renderer;
use Pi\Lib\Json;

// A faire : à revoir entièrement
class App {
	/** @var Renderer */
	protected $renderer;

	/** @var string */
	protected $path;

	/** @var string */
	protected $query;

	/** @var string */
	protected $theme;

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
		if (0 !== strpos($class, 'Pi'))
			return;

		$parts = explode('\\', $class);

		$newParts = [];

		for ($i = 0, $len = count($parts) ; $i < $len ; $i++) {
			if ($i == count($parts) - 1)
				$newParts[] = $parts[$i];
			else
				$newParts[] = strtolower($parts[$i]);
		}

		$fileName = implode(DS, $newParts);

		$file = dirname(__FILE__) . '/../' . $fileName . '.php';

		if (is_file($file))
			require $file;
		else
			throw new \Exception('Unable to load "' . $file . '"');
	}

	/**
	 */
	public function __construct() {
		$this->initializeTheme();
		$this->initializePath();
		$this->initializeRenderer();

		$this->processPost();
	}

	/**
	 * Traite les données reçues via POST
	 *
	 * @throws Exception
	 */
	public function processPost() {
		if (!empty($_POST)) {
			$fileModel = PI_DIR_MODELS . $_POST['model'] . '/model.json';

			$model = new Model($fileModel);
			$form = new Form($model);

			if (!$form->validate())
				throw new Exception('Error in form');

			$content = [
				'model' => $_POST['model'],
				'created_at' => time(),
				'updated_at' => time(),
				'fields' => $form->save()
			];

			$folder = PI_DIR_PAGES . $this->getPath() . '/';

			if (!file_exists($folder))
				mkdir($folder, 0755, true);

			Json::write($folder . time() . '.json', $content);
		}
	}

	/**
	 * Initilise le moteur de rendu
	 */
	public function initializeRenderer() {
		$this->renderer = new Renderer($this->theme);
	}

	/**
	 * Initialise le thème courant
	 *
	 * @todo si le thème courant n'existe pas, renvoyer une erreur
	 */
	public function initializeTheme() {
		$this->theme = 'default';

		$this->theme = Settings::get('site.theme');

		if (!$this->theme)
			$this->theme = 'default';

		define('PI_DIR_THEME', PI_DIR_THEMES . $this->theme . DS);
		define('PI_URL_THEME', PI_URL_THEMES . $this->theme . '/');
		
		require PI_DIR_THEME . 'init.php';
	}

	/**
	 * Initialise le chemin courant
	 */
	public function initializePath() {
		$this->path = 'home';
		$this->query = '';

		if (isset($_SERVER['PATH_INFO'])) {
			// /page/test/&edit
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$this->path = trim($matches[1], '/'); // page/test
			$this->query = trim($matches[2], '/'); // edit
		}

		if (empty($this->path))
			$this->path = 'home';
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
		$mainVariables = $this->getVariables();
		$variables = array_merge($mainVariables, $variables);

		return $this->renderer->render($file, $variables);
	}

	/**
	 * Variables globales qui seront envoyées à toutes les vues
	 *
	 * @return array
	 */
	public function getVariables() {
		return [
			'app' => $this,
			'settings' => Settings::getSettings(),
			'url' => [
				'site' => PI_URL_SITE,
				'content' => PI_URL_CONTENT,
				'models' => PI_URL_MODELS,
				'pages' => PI_URL_PAGES,
				'themes' => PI_URL_THEMES,
				'theme' => PI_URL_THEME,
				'curent' => $this->getPath()
			],
			'dir' => [
				'site' => PI_DIR_SITE,
				'content' => PI_DIR_CONTENT,
				'models' => PI_DIR_MODELS,
				'pages' => PI_DIR_PAGES,
				'themes' => PI_DIR_THEMES,
				'theme' => PI_DIR_THEME
			],
			'jsUrls' => Loader::getJsUrls(),
			'cssUrls' => Loader::getCssUrls()
		];
	}

	/**
	 * Obtention de l'URL courante
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Lance la recherche de la page et la retourne
	 */
	public function run() {
		if ($this->query == 'edit') {
			$content = Page::getLastVersion($this->getPath());

			if (!$content) {
				echo $this->render('admin/create-page.html', [
					'models' => [
						'page' => 'page',
						'article' => 'article',
						'all' => 'all'
					]
				]);

				return;
			}

			$fileModel = PI_DIR_MODELS . $content['model'] . '/model.json';

			$model = new Model($fileModel);
			$form = new Form($model);

			if (empty($_POST))
				$_POST = $content['fields'];

			echo $this->render('admin/edit-page.html', [
				'form' => $form
			]);
		} else {
			$content = Page::getLastVersion($this->getPath());

			if (!$content)
				$content = Page::getLastVersion('error');

			$model = $content['model'];
			$fields = $content['fields'];

			$meta = [
				'title' => $content['title'],
				'model' => $model,
				'created_at' => $content['created_at'],
				'updated_at' => $content['updated_at']
			];

			echo $this->render($model . '/view.html', [
				'page' => $fields,
				'meta' => $meta
			]);
		}
	}

	/**
	 * Récupérer tous les utilisateurs
	 *
	 * @return User[]
	 */
	public function getAllUsers() {
		return Settings::getUsers();
	}

	/**
	 * Récupérer toutes les pages
	 *
	 * @return PageCollection
	 */
	public function getAllPages() {
		$users = $this->getAllUsers();

		return PageCollection::getAllPages();
	}

	/**
	 * Récupérer une page
	 *
	 * @param Page $page
	 *
	 * @return bool|mixed
	 */
	public static function getPage($page) {
		$p = Page::getLastVersion($page);

		return $p;
	}
}
