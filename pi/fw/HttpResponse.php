<?php

class HttpResponse {
	private $defaultsParams = [
		'contentType' => 'text/html',
		'statusCode' => 200
	];

	public function __construct($response, array $params) {
		$params = array_merge($this->defaultsParams, $params);
	}
}
