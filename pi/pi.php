<?php

namespace Pi;

use Exception;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
use Pi\Lib\Markdown;
use Pi\Lib\Yaml;
use Pi\Core\Page;
use Pi\Core\Model;
use Pi\Core\Form;

// A faire : à revoir entièrement
class App {
	private $loader;
	private $twig;
	private $path;
	private $query;
	private $theme;

	public static function register() {
		spl_autoload_register([ __CLASS__, 'autoload' ]);
	}

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

	public function __construct() {
		$this->path = 'home';
		$this->query = '';
		$this->theme = 'default';

		if (isset($_SERVER['PATH_INFO'])) {
			// /page/test/&edit
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$this->path = trim($matches[1], '/'); // page/test
			$this->query = trim($matches[2], '/'); // edit
		}

		$this->initializeTwig();

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

			Yaml::write('content/pages/' . $this->path . '/' . time() . '.yaml', $content);
		}
	}

	public function initializeTwig() {
		// Définition du dossier des modèles de page
		$this->loader = new Twig_Loader_Filesystem('./content/themes/' . $this->theme . '/tpl');
		$this->loader->addPath('./content/models');

		$this->twig = new Twig_Environment($this->loader);

		// Fonction « genLink » : « genLink('about') »
		$this->twig->addFunction(new Twig_SimpleFunction('genLink', function($url, array $options = []) {
			array_unshift($options, $url);
			return call_user_func_array([ $this, 'genLink' ], $options);
		}, [ 'is_variadic' => true ]));

		// Filtre markdown : « ma_variable|markdown »
		$this->twig->addFilter(new Twig_SimpleFilter('markdown', function($text) {
			return Markdown::html($text);
		}, [ 'is_safe' => [ 'html' ] ]));
	}

	public function render($file, $variables = []) {
		$mainVariables = $this->getVariables();
		$variables = array_merge($mainVariables, $variables);

		return $this->twig->render($file, $variables);
	}

	public function getVariables() {
		return [
			'app' => $this,
			'currentUrl' => $this->path,
			'dir' => [
				'theme' => '/content/themes/' . $this->theme . '/'
			]
		];
	}

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
