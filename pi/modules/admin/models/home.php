<?php

use Pi\Core\Model;

$app->get('admin.models.home', 'admin/models', function($app) {
	$page = $app->view('admin/models/views/home.php');
	$filesModels = glob('content/models/*');

	$models = [];

	foreach ($filesModels as $file)
		$models[] = new Model($file . '/model.yaml');

	$page->models = $models;

	return $page;
});
