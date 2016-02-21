<?php

namespace Pi;

use Exception;

use Pi\Core\Page;
use Pi\Core\Renderer;

// A faire : à revoir entièrement
class App {
	private $renderer;
	private $path;
	private $query;
	private $theme;

	/// Enregistre l'« autoloader »
	public static function register() {
		spl_autoload_register([ __CLASS__, 'autoload' ]);
	}

	/// Quand l'utilisation d'une classe est repérée, le fichier créant la
	/// classe est chargé
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
			throw new Exception('Unable to load "' . $file . '"');
	}

	/// Constructeur
	public function __construct() {
		$this->theme = 'default';

		$this->initializePath();
		$this->renderer = new Renderer($this->theme);

		if (!empty($_POST)) {
			$fileModel = 'content/models/' . $_POST['model'] . '/model.yaml';

			$model = new Model($fileModel);
			$form = new Form($model);

			$content = [
				'model' => $_POST['model'],
				'created_at' => time(),
				'updated_at' => time(),
				'fields' => $form->save()
			];

			Yaml::write('content/pages/' . $this->getPath() . '/' . time() . '.yaml', $content);
		}
	}

	/// Initialise le chemin courant
	public function initializePath() {
		$this->path = 'home';
		$this->query = '';

		if (isset($_SERVER['PATH_INFO'])) {
			// /page/test/&edit
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$this->path = trim($matches[1], '/'); // page/test
			$this->query = trim($matches[2], '/'); // edit
		}
	}

	/// Rendu du fichier
	public function render($file, $variables = []) {
		$mainVariables = $this->getVariables();
		$variables = array_merge($mainVariables, $variables);

		return $this->renderer->render($file, $variables);
	}

	/// Variables globales qui seront envoyées à toutes les vues
	public function getVariables() {
		return [
			'app' => $this,
			'currentUrl' => $this->getPath(),
			'dir' => [
				'theme' => '/content/themes/' . $this->theme . '/'
			]
		];
	}

	/// Obtention de l'URL courante
	public function getPath() {
		return $this->path;
	}

	public function run() {
		if ($this->query == 'edit') {
			$content = Page::getLastVersion($this->getPath());

			$fileModel = 'content/models/' . $content['model'] . '/model.yaml';

			$model = new Model($fileModel);
			$form  = new Form($model);

			if (empty($_POST))
				$_POST = $content['fields'];

			echo $this->render('edit.html', [
				'form' => $form
			]);
		} else {
			$content = Page::getLastVersion($this->getPath());

			if (!$content)
				$content = Page::getLastVersion('error');

			$model = $content['model'];
			$fields = $content['fields'];

			$meta = [
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
}
