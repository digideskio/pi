<?php

namespace Pi;

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFilter;
use Pi\Lib\Markdown;
use Pi\Core\Page;

// A faire : à revoir entièrement
class App {
	private $loader;
	private $twig;
	private $path;

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

		if (isset($_SERVER['PATH_INFO'])) {
			// /page/test/&edit => page/test
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?.*/', $_SERVER['PATH_INFO'], $matches);
			$this->path = trim($matches[1], '/');
		}

		$this->loader = new Twig_Loader_Filesystem('./pi/views');
		$this->loader->addPath('./content/models');
		$this->twig = new Twig_Environment($this->loader);

		$this->twig->addFilter(new Twig_SimpleFilter('markdown', function($text) {
			return Markdown::html($text);
		}, [ 'is_safe' => [ 'html' ] ]));
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
