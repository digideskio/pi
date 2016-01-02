<?php

use Pi\Core\Model;
use Pi\Core\Form;
use Pi\Lib\Yaml;
use Pi\Lib\Input;

$app->get('admin.home', 'admin', function($app) {
	$filesModels = glob('content/models/*');

	$models = [];

	foreach ($filesModels as $file)
		$models[] = new Model($file . '/model.yaml');

	return $app->render('admin/home.html', [
		'models' => $models
	]);
});

$app->post('admin.home', 'admin', function($app) {
	$model = Input::get('model');

	return $app->redirect('GET admin.models.use', $model);
});
