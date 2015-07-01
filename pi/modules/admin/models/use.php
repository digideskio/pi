<?php

use Pi\Core\Model;
use Pi\Core\Form;

$app->get('admin.models.use', 'admin/models/{slug}/use', function($app, $slug) {
	$page = $app->view(__DIR__ . DS . 'views' . DS . 'use.php');

	$fileModel = 'content/models/' . $slug . '.yaml';

	$model = new Model($fileModel);
	$form  = new Form($model);

	$page->form = $form;

	echo $page;
});

$app->post('admin.models.use', 'admin/models/{slug}/use', function($app, $slug) {

});
