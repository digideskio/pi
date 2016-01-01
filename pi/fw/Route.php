<?php

class Route {
	private $method;
	private $name;
	private $path;
	private $handler;

	public function __construct() {

	}

	public function getMethod() {
		return $this->method;
	}

	public function getName() {
		return $this->name;
	}

	public function getPath() {
		return $this->path;
	}

	public function getHandler() {
		return $this->handler;
	}

	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}

	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	public function setPath($path) {
		$this->path = $path;
		return $this;
	}

	public function setHandler($handler) {
		$this->handler = $handler;
		return $this;
	}
}
