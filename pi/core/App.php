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

use Pi\Lib\Json;
use Pi\Model\Field\BaseField;
use Pi\Model\Form;
use Pi\Model\Model;
use Pi\Page\Page;
use Pi\Render\Renderer;

class App {
	/** @var Renderer */
	protected $renderer;

	/** @var string */
	protected $query;

	/** @var string */
	protected $theme;

	/** @var array */
	protected static $models;

	/** @var array */
	protected static $fields;

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
		if (strpos($class, 'Pi') !== 0 && strpos($class, 'Module') !== 0)
			throw new Exception('Namespace should starts with "Pi" or
				"Module"');

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
			$file = realpath(__DIR__ . '/../../') . DS
				. $fileName . '.php';
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
		} else {
			throw new Exception('Unable to load class "' . $class . '"');
		}

		if (is_file($file))
			require $file;
		else
			throw new Exception('Unable to load "' . $file . '"');
	}

	/**
	 * @param $name
	 *
	 * @return BaseField
	 *
	 * @throws Exception
	 */
	public static function getField($name) {
		if (isset(static::$fields[$name]))
			return static::$fields[$name];
		else
			throw new Exception('Field "' . $name . '" does not exists.');
	}

	/**
	 * Contruction de l'application
	 */
	public function __construct() {
		$this->initializeTheme();
		$this->initializeRenderer();
		$this->initializeModules();
		$this->initializeAttributes();

		$this->processPost();
	}

	/**
	 * Initialise le thème courant
	 *
	 * @todo si le thème courant n'existe pas, renvoyer une erreur
	 */
	protected function initializeTheme() {
		$this->theme = 'default';

		$this->theme = Settings::get('site.theme');

		if (!$this->theme)
			$this->theme = 'default';

		define('PI_DIR_THEME', PI_DIR_THEMES . $this->theme . DS);
		define('PI_URL_THEME', PI_URL_THEMES . $this->theme . '/');

		if (file_exists(PI_DIR_THEME . 'init.php'))
			require PI_DIR_THEME . 'init.php';
		else
			throw new Exception('Unable to load "init.php" for theme "'
				. $this->theme . '"');
	}

	/**
	 * Initilise le moteur de rendu
	 */
	protected function initializeRenderer() {
		$this->renderer = new Renderer();
		$this->renderer->addPath(PI_DIR_MODELS);
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
			else
				throw new Exception('Missing "module.php" in module "'
					. $dir . '"');
		}
	}

	/**
	 * Initialisation des attributs
	 */
	protected function initializeAttributes() {
		static::$models = [];

		foreach (scandir(PI_DIR_MODELS) as $dir) {
			if ($dir == '.' || $dir == '..')
				continue;

			static::$models[] = new Model($dir);
		}
	}

	/**
	 * Traite les données reçues via POST
	 *
	 * @throws Exception
	 */
	protected function processPost() {
		if (!empty($_POST)) {
			$model = new Model($_POST['model']);
			$form = new Form($model);

			if (!$form->validate())
				throw new Exception('Error in form');

			$content = [
				'model' => $_POST['model'],
				'created_at' => time(),
				'updated_at' => time(),
				'fields' => $form->save()
			];

			$folder = PI_DIR_PAGES . Router::getPath() . '/';

			if (!file_exists($folder))
				mkdir($folder, 0755, true);

			Json::write($folder . time() . '.json', $content);
		}
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
	 * Lance la recherche de la page et la retourne
	 */
	public function run() {
		if ($this->query == 'edit') {
			$content = Page::getLastVersion(Router::getPath());

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

			$model = new Model($content['model']);
			$form = new Form($model);

			if (empty($_POST))
				$_POST = $content['fields'];

			echo $this->render('admin/edit-page.html', [
				'form' => $form
			]);
		} else {
			$content = Page::getLastVersion(Router::getPath());

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

	/**
	 * Enregistrer un nouveau modèle
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelFilename Chemin vers le fichier modèle (JSON)
	 * @param string $viewFilename Chemin vers le fichier vue (Twig)
	 *
	 * @return bool true si le modèle a pu être enregistré, false sinon
	 */
	public static function registerModel($modelName, $modelFilename = null,
	                                     $viewFilename = null) {
		static::$models[] = new Model(
			$modelName,
			$modelFilename,
			$viewFilename);

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
	public static function registerField($fieldName, $fieldClass) {
		static::$fields[$fieldName] = $fieldClass;

		return true;
	}

	/**
	 * Surcharger un modèle
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelFilename Chemin vers le fichier modèle (JSON)
	 * @param string $viewFilename Chemin vers le fichier vue (Twig)
	 *
	 * @return bool true si le modèle a pu être surchargé, false sinon
	 */
	public static function overrideModel($modelName, $modelFilename,
	                                     $viewFilename) {
		return true;
	}

	/**
	 * Surcharger la vue d'un modèle
	 *
	 * @param string $modelName Nom du modèle à surcharger
	 * @param string $filename Chemin vers la vue surchargée
	 *
	 * @return bool true si la vue a pu être surchargée, false sinon
	 */
	public static function overrideViewModel($modelName, $filename) {
		return true;
	}

	/**
	 * Surcharger un champ
	 *
	 * @param string $fieldName Nom du champ
	 * @param string $fieldClass Classe du champ
	 *
	 * @return bool true si la vue a pu être surchargée, false sinon
	 */
	public static function overrideField($fieldName, $fieldClass) {
		return true;
	}
}
