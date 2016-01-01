<?php

class App {
	private $routes;

	public function __construct() {
		$this->routes = [];
	}

	public function get($name, $path, callable $handler) {
		return $this->handle('GET', $name, $path, $handler);
	}

	/*
	public function head($name, $path, callable $handler) {
		return $this->handle('HEAD', $name, $path, $handler);
	}
	*/

	public function post($name, $path, callable $handler) {
		return $this->handle('POST', $name, $path, $handler);
	}

	/*
	public function options($name, $path, callable $handler) {
		return $this->handle('OPTIONS', $name, $path, $handler);
	}
	*/

	/*
	public function connect($name, $path, callable $handler) {
		return $this->handle('CONNECT', $name, $path, $handler);
	}
	*/

	/*
	public function trace($name, $path, callable $handler) {
		return $this->handle('TRACE', $name, $path, $handler);
	}
	*/

	public function put($name, $path, callable $handler) {
		return $this->handle('PUT', $name, $path, $handler);
	}

	/*
	public function patch($name, $path, callable $handler) {
		return $this->handle('PATCH', $name, $path, $handler);
	}
	*/

	public function delete($name, $path, callable $handler) {
		return $this->handle('DELETE', $name, $path, $handler);
	}

	public function any($name, $path, callable $handler) {
		return $this->handle('*', $name, $path, $handler);
	}

	public function route(array $methods, $name, $path, callable $handler) {
		foreach ($methods as $method)
			$this->handle($method, $name, $path, $handler);
	}

	public function run() {

	}

	private function handle($method, $name, $path, $handler) {
		$route = new Route();
		$route->setMethod($method);
		$route->setName($name);
		$route->setPath($path);
		$route->setHandler($handler);

		$this->routes[] = $route;

		return $route;
	}
}
