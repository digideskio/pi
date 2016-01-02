<?php

use Pi\Lib\Yaml;
use Pi\Lib\Input;
use Pi\Lib\Str;
use Pi\Lib\Flash;

$app->get('admin.pages.create', 'admin/pages/create', function($app) {
	$fileModel = 'content/models/' . $slug . '/model.yaml';

	$model = new Model($fileModel);
	$form  = new Form($model);

	return $app->render('admin/pages/create.html', [
		'form' => $form
	]);
});

$app->post('admin.pages.create', 'admin/pages/create', function($app) {
	$slug = Input::get('model');

	$fileModel = 'content/models/' . $slug . '/model.yaml';

	$model = new Model($fileModel);
	$form = new Form($model);

	$content = [
		'model' => $slug,
		'created_at' => time(),
		'updated_at' => time(),
		'fields' => $form->save()
	];

	Yaml::write('content/pages/' . time() . '.yaml', $content);

	return $app->redirect('GET admin.models.home');
});
