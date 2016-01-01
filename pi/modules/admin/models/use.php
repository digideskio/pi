<?php

use Pi\Core\Model;
use Pi\Core\Form;
use Pi\Lib\Yaml;

$app->get('admin.models.use', 'admin/models/{slug}/use', function($app, $slug) {
	$fileModel = 'content/models/' . $slug . '/model.yaml';

	$model = new Model($fileModel);
	$form  = new Form($model);

	return $app->render('admin/models/use.html', [
		'form' => $form
	]);
});

$app->post('admin.models.use', 'admin/models/{slug}/use', function($app, $slug) {
	$fileModel = 'content/models/' . $slug . '/model.yaml';

	$model = new Model($fileModel);
	$form = new Form($model);

	$yaml = Yaml::encode($form->save());

	Yaml::write('content/pages/' . time() . '.yaml', $form->save());

	echo '<pre>' . $yaml . '</pre>';
});
