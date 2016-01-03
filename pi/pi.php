<?php

namespace Pi;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFilter;
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
	}

	public function __construct() {
		$this->path = 'home';
		$this->query = '';

		if (isset($_SERVER['PATH_INFO'])) {
			// /page/test/&edit
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$this->path = trim($matches[1], '/'); // page/test
			$this->query = trim($matches[2], '/'); // edit
		}

		$this->loader = new Twig_Loader_Filesystem('./pi/views');
		$this->loader->addPath('./content/models');
		$this->twig = new Twig_Environment($this->loader);

		$this->twig->addFilter(new Twig_SimpleFilter('markdown', function($text) {
			return Markdown::html($text);
		}, [ 'is_safe' => [ 'html' ] ]));

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

	public function render($file, $variables = []) {
		$variables = array_merge([
			'app' => $this,
			'currentUrl' => $this->path
		], $variables);

		return $this->twig->render($file, $variables);
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
