<?php

use Pi\Core\Model;

$app->get('admin.models.home', 'admin/models', function($app) {
	$filesModels = glob('content/models/*');

	$models = [];

	foreach ($filesModels as $file)
		$models[] = new Model($file . '/model.yaml');

	return $app->render('admin/models/home.html', [
		'models' => $models
	]);
});
