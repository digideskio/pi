<?php

declare(strict_types=1);

require 'init.php';

$pages = $app->getPagesRepository()->findAll();

$themes = $app->getThemes();

echo $app->render('@theme/admin-pages/settings.html', [
	'pages' => $pages,
	'menu_items' => $menuItems,
	'themes' => $themes
]);
