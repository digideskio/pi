<?php

require 'init.php';

$pages = $app->getPagesRepository()->findAll();

echo $app->render('@theme/admin/dashboard.html', [
	'pages' => $pages,
	'menu_items' => $menuItems
]);
