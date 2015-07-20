<?php

use Pi\Lib\Yaml;
use Pi\Lib\Input;
use Pi\Lib\Flash;

$app->get('admin.models.edit', 'admin/models/{slug}/edit', function($app, $slug) {
	$file = 'content/models/' . $slug . '.yaml';

	if (file_exists($file)) {
		$content = $app->view('admin/models/views/edit.php');

		$content->content = file_get_contents($file);

		return $content;
	}

	return $app->redirect('GET /');
});

$app->post('admin.models.edit', 'admin/models/{slug}/edit', function($app, $slug) {
	$content = Input::get('content');
	$yaml = Yaml::read($content);

	if (!empty($content) && isset($yaml['title'], $yaml['fields'])) {
		$title = $yaml['title'];

		$file = 'content/models/' . $slug . '.yaml';

		Yaml::write($file, $yaml);
		Flash::pushSuccess('Modèle modifié avec succès');

		return $app->redirect('GET admin.models.home');
	} else {
		Flash::pushError('Le contenu fourni est invalide, il doit contenir
			un title ("title") et des champs ("fields")');
	}

	return $app->redirect('GET admin.models.create');
});
