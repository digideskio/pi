<?php

use Pi\Core\Model;
use Pi\Core\Form;
use Pi\Lib\Yaml;

$app->get('admin.home', 'admin', function($app) {
	$page = $app->view(__DIR__ . DS . 'views' . DS . 'home.php');
	$filesModels = glob('content/models/*.yaml');

	$models = [];

	foreach ($filesModels as $file) {
		$models[] = new Model($file);
	}

	$page->models = $models;

	return $page;
});
