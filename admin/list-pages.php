<?php

declare(strict_types=1);

require 'init.php';

$pages = $app->getPagesRepository()->findAll();

echo $app->render('@theme/admin-pages/list-pages.html', [
	'pages' => $pages,
	'menu_items' => $menuItems
]);
