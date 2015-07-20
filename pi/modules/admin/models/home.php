<?php

use Pi\Core\Model;

$app->get('admin.models.home', 'admin/models', function($app) {
	$page = $app->view('admin/models/views/home.php');
	$filesModels = glob('content/models/*.yaml');

	$models = [];

	foreach ($filesModels as $file) {
		$models[] = new Model($file);
	}

	$page->models = $models;

	return $page;
});
