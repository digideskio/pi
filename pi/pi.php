<?php

namespace Pi;

use \Exception;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Twig_SimpleFunction;
use Pi\Lib\Str;

// A faire : à revoir entièrement
class App {
	private $routes;
	private $loader;
	private $twig;

	private static $shortcuts = [
		'{char}'   => '([a-zA-Z_])',      // character
		'{digit}'  => '([0-9])',          // digit
		'{string}' => '([a-zA-Z_]+)',     // string
		'{number}' => '([0-9]+)',         // number
		'{slug}'   => '([a-zA-Z0-9_-]+)', // alphanumeric
		'{*}'      => '(.+)'              // all
	];

	public function __construct() {
		$this->routes = [];

		$this->loader = new Twig_Loader_Filesystem('./pi/views');
		$this->twig = new Twig_Environment($this->loader);

		$this->twig->addFunction(new Twig_SimpleFunction('genLink', function($url, array $options = []) {
			array_unshift($options, $url);
			return call_user_func_array([ $this, 'genLink' ], $options);
		}, [ 'is_variadic' => true ]));
	}

	public function route($name, $path, $func, $method = 'GET') {
		$methods = is_array($method) ? $method : [ $method ];

		foreach ($methods as $method) {
			$method = strtoupper($method);

			$this->routes[$method . ' ' . $name] = [
				'path'   => $path,
				'func'   => $func,
				'method' => $method
			];
		}

		return $this;
	}

	public function get($name, $path, $func) {
		return $this->route($name, $path, $func, 'GET');
	}

	public function post($name, $path, $func) {
		return $this->route($name, $path, $func, 'POST');
	}

	public function run() {
		$tryPath = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
		$method = 'GET';
		$found = false;

		if (isset($_SERVER['REQUEST_METHOD']))
			$method = $_SERVER['REQUEST_METHOD'];

		$matches = [];

		foreach ($this->routes as $k => $v) {
			$path = strtr($v['path'], self::$shortcuts);

			if (
				preg_match('#^/?' . $path . '/?$#U', $tryPath, $matches)
				&&
				$v['method'] == $method
			) {
				array_splice($matches, 0, 1);

				$matches = array_map(function($match) {
					return trim($match, '/');
				}, $matches);

				array_unshift($matches, $this);

				$content = call_user_func_array($v['func'], $matches);

				echo $content;

				$found = true;
				break;
			}
		}

		if (!$found)
			exit;

		return $this;
	}

	public function genLink($routeName) {
		if ($this->routes[$routeName]['path'] == '/')
			return '/';

		$args = func_get_args();
		array_splice($args, 0, 1);

		$path = $this->routes[$routeName]['path']; // A faire : à revoir

		$link = preg_replace_callback('~\{.+\}~U', function($matches) use($args) {
			static $i = 0;

			if (isset($args[$i]))
				return $args[$i++];
			else
				return '';
		}, str_replace('?', '', $path));

		$link = rtrim($link, '/');

		return '/' . $link;
	}

	public function redirect($routeName) {
		header('Location: ' . call_user_func_array([ $this, 'genLink' ], func_get_args()));
		exit;
	}

	public function render($file, $variables = []) {
		return $this->twig->render($file, $variables);
	}
}
