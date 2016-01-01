<?php

use Pi\Core\Model;
use Pi\Core\Form;
use Pi\Lib\Yaml;

$app->get('admin.home', 'admin', function($app) {
	$filesModels = glob('content/models/*');

	$models = [];

	foreach ($filesModels as $file)
		$models[] = new Model($file . '/model.yaml');

	return $app->render('admin/models/home.html', [
		'models' => $models
	]);
});
