<?php

use Pi\Core\Model;
use Pi\Core\Form;

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
	$form  = new Form($model);

	var_dump($form->save(), true);
});
