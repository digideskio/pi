<?php

use Pi\Lib\Yaml;
use Pi\Lib\Input;
use Pi\Lib\Str;
use Pi\Lib\Flash;

$app->get('admin.models.create', 'admin/models/create', function($app) {
	return $app->render('admin/models/create.html');
});

$app->post('admin.models.create', 'admin/models/create', function($app) {
	$content = Input::get('content');
	$yaml = Yaml::read($content);

	if (!empty($content) && isset($yaml['title'], $yaml['fields'])) {
		$title = $yaml['title'];
		$slug = Str::slug($title);

		$file = 'content/models/' . $slug . '/model.yaml';

		if (!file_exists($file)) {
			Yaml::write($file, $yaml);
			Flash::pushSuccess('Modèle créé avec succès');
			return $app->redirect('GET admin.models.home');
		}

		Flash::pushError('Un autre modèle porte déjà ce nom');
	} else {
		Flash::pushError('Le contenu fourni est invalide, il doit contenir
			un title ("title") et des champs ("fields")');
	}

	return $app->redirect('GET admin.models.create');
});
