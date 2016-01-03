<?php

namespace Pi;

use \Exception;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;
use \Twig_SimpleFilter;
use Pi\Lib\Str;
use Pi\Lib\Markdown;

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

	public function __construct($path) {
		$this->path = $path;

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
}
