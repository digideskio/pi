<?php

class App {
	private $routes;

	public function __construct() {
		$this->routes = [];
	}

	public function get($path, callable $handler) {
		return $this->handle('GET', $path, $handler);
	}

	public function head($path, callable $handler) {
		return $this->handle('HEAD', $path, $handler);
	}

	public function post($path, callable $handler) {
		return $this->handle('POST', $path, $handler);
	}

	public function options($path, callable $handler) {
		return $this->handle('OPTIONS', $path, $handler);
	}

	public function connect($path, callable $handler) {
		return $this->handle('CONNECT', $path, $handler);
	}

	public function trace($path, callable $handler) {
		return $this->handle('TRACE', $path, $handler);
	}

	public function put($path, callable $handler) {
		return $this->handle('PUT', $path, $handler);
	}

	public function patch($path, callable $handler) {
		return $this->handle('PATCH', $path, $handler);
	}

	public function delete($path, callable $handler) {
		return $this->handle('DELETE', $path, $handler);
	}

	public function any($path, callable $handler) {
		return $this->handle('*', $path, $handler);
	}

	public function route(array $methods, $path, callable $handler) {
		foreach ($methods as $method)
			$this->handle($method, $path, $handler);
	}

	public function run() {

	}

	private function handle($method, $path, $handler) {
		$route = new Route();
		$route->setMethod($method);
		$route->setPath($path);
		$route->setHandler($handler);

		$this->routes[] = $route;

		return $route;
	}
}
