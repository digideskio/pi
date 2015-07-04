<?php

$app->post('admin.models.remove', 'admin/models/{slug}/remove', function($app, $slug) {
	$file = 'content/models/' . $slug . '.yaml';

	if (file_exists($file)) {
		unlink($file);
		return $app->redirect('GET admin.models.home');
	} else {
		return $app->redirect('GET /');
	}
});
