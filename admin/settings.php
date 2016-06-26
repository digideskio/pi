<?php

require 'init.php';

use Pi\Core\Page\PageCollection;

$pages = PageCollection::getAllPages();

/** @todo */
$themes = [
	'default' => 'Default'
];

echo $app->render('@theme/admin/settings.html', [
	'pages' => $pages,
	'menu_items' => $menuItems,
	'themes' => $themes
]);
