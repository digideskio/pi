<?php

$app->post('admin.models.remove', 'admin/models/{slug}/remove', function($app, $slug) {
	// à faire : à revoir (tester le risque d'erreur)
	unlink('content/models/' . $slug . '/model.yaml');
	unlink('content/models/' . $slug . '/view.php');
	rmdir('content/models/' . $slug);

	return $app->redirect('GET admin.models.home');
});
