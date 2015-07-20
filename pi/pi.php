<?php

namespace Pi;

use Exception;
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

				$content = call_user_func_array($v['func'], $matches);

				echo $content->render();

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
	protected $file = '';

	protected $layoutName;
	protected $layoutData = [];
	protected $sections = [];
	protected $data = [];

	public function __construct($file) {
		$file = __DIR__ . DS . 'modules' . DS . $file;

		try {
			if (file_exists($file)) {
				$this->file = $file;
			} else {
				throw new Exception('Le fichier de vue "' . $file . '" n\'existe pas');
			}
		} catch(Exception $e) {
			exit($e);
		}
	}

	public function __set($key, $value) {
		if ($value instanceof View)
			$this->data[$key] = (string) $value;
		else
			$this->data[$key] = $value;
	}

	public function layout($name) {
		$this->layoutName = $name;
	}

	public function begin($name) {
		$this->sections[$name] = '';
		ob_start();
	}

	public function end() {
		end($this->sections);
		$this->sections[key($this->sections)] = ob_get_clean();
	}

	protected function section($name, $default = null) {
		if (!isset($this->sections[$name]))
			return $default;

		return $this->sections[$name];
	}

	public function render($data = []) {
		try {
			$this->data = array_merge($this->data, $data);
			unset($data);
			extract($this->data);
			ob_start();

			include $this->path();

			$content = ob_get_clean();

			if (isset($this->layoutName)) {
				$layout = new View($this->layoutName);

				$layout->sections = array_merge($this->sections);

				$content = $layout->render($this->layoutData);
			}

			return $content;
		} catch (LogicException $e) {
			if (ob_get_length() > 0) {
				ob_end_clean();
			}

			throw $e;
		}
	}

	public function path() {
		return $this->getPath();
	}

	public function getPath() {
		return $this->file;
	}
}

$app = new App();

require 'modules/site/home.php';
require 'modules/admin/home.php';
require 'modules/admin/models/create.php';
require 'modules/admin/models/edit.php';
require 'modules/admin/models/home.php';
require 'modules/admin/models/import.php';
require 'modules/admin/models/remove.php';
require 'modules/admin/models/use.php';

$app->run();
