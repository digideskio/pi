<?php

require 'init.php';

use Pi\App\App;
use Pi\App\PageCollection;

$pages = PageCollection::getAllPages();

$app = new App();

$themes = [
	'default' => 'Default'
];

echo $app->render('admin/settings.html', [
	'pages' => $pages,
	'menu_items' => $menuItems,
	'themes' => $themes
]);
