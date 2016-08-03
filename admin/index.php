<?php

declare(strict_types=1);

require 'init.php';

$pages = $app->getPagesRepository()->getAll();

echo $app->render('@theme/admin-pages/dashboard.html', [
	'pages' => $pages,
	'menu_items' => $menuItems
]);
