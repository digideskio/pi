<?php

use Pi\Core\Model;
use Pi\Core\Form;
use Pi\Lib\Yaml;

$app->get('admin.home', 'admin', function($app) {
	$page = $app->view('admin/models/views/home.php');
	$filesModels = glob('content/models/*');

	$models = [];

	foreach ($filesModels as $file)
		$models[] = new Model($file . '/model.yaml');

	$page->models = $models;

	return $page;
});
