<?php

require 'init.php';

$pages = $app->getPagesRepository()->findAll();

$themes = $app->getThemes();

echo $app->render('@theme/admin/settings.html', [
	'pages' => $pages,
	'menu_items' => $menuItems,
	'themes' => $themes
]);
