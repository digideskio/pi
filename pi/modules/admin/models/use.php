<?php

use Pi\Core\Model;
use Pi\Core\Form;

$app->get('admin.models.use', 'admin/models/{slug}/use', function($app, $slug) {
	$page = $app->view('admin/models/views/use.php');

	$fileModel = 'content/models/' . $slug . '.yaml';

	$model = new Model($fileModel);
	$form  = new Form($model);

	$page->form = $form;

	return $page;
});

$app->post('admin.models.use', 'admin/models/{slug}/use', function($app, $slug) {
	$fileModel = 'content/models/' . $slug . '.yaml';

	$model = new Model($fileModel);
	$form  = new Form($model);

	var_dump($form->save());
});
