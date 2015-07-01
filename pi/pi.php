<?php

namespace Pi;

use Pi\Lib\Str;

// A faire : à revoir entièrement
class App {
	private $routes;

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
		$method  = 'GET';
		$found   = false;

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

				ob_start();

				call_user_func_array($v['func'], $matches);

				$ob = ob_get_clean();

				echo '
					<!DOCTYPE html>
					<html>

						<head>
							<meta charset="utf-8" />
							<title>Pi</title>

							<link rel="stylesheet" href="/web/css/style.min.css" />
						</head>

						<body>
				';

				echo $ob;

				echo '
						</body>
					</html>
				';

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
		header('Location: ' . call_user_func_array([$this, 'genLink'], func_get_args()));

		exit;
	}

	public function view($file) {
		$view = new View($file);
		$view->app = $this;

		return $view;
	}
}

class View {
	protected $vars = [];
	protected $file = '';

	public function __construct($file) {
		try {
			if (file_exists($file)) {
				$this->file = $file;
			} else {
				throw new Exc('Le fichier de vue "' . $file . '" n\'existe pas');
			}
		} catch(Exc $e) {
			exit($e);
		}
	}

	public function __set($key, $value) {
		if ($value instanceof View)
			$this->vars[$key] = (string) $value;
		else
			$this->vars[$key] = $value;
	}

	public function __toString() {
		ob_start();
		extract($this->vars);

		require $this->file;

		$_C = ob_get_contents();
		ob_end_clean();

		return $_C;
	}
}

$app = new App();

require 'modules/site/home.php';
require 'modules/admin/home.php';
require 'modules/admin/models/create.php';
require 'modules/admin/models/edit.php';
require 'modules/admin/models/home.php';
require 'modules/admin/models/remove.php';
require 'modules/admin/models/use.php';

$app->run();
