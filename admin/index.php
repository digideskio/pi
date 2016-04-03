<?php

require '../settings.php';

use Pi\App;
use Pi\PageCollection;

session_start();

function isConnected() {
	return isset($_SESSION['username']);
}

$_SESSION['username'] = 'super-admin';

$pages = PageCollection::getAllPages();

$app = new App();

echo $app->render('admin/dashboard.html', [
	'pages' => $pages,

	'menu_items' => [
		'Tableau de bord' => PI_URL_SITE . 'admin/',
		'Pages' => PI_URL_SITE . 'admin/list-pages.php',
		'Modèles' => PI_URL_SITE . 'admin/list-models.php',
		'Configurations' => PI_URL_SITE . 'admin/settings.php',
		'Avancés' => PI_URL_SITE . 'admin/advanced.php'
	]
]);
