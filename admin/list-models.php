<?php

require 'init.php';

use Pi\App;
use Pi\PageCollection;

$pages = PageCollection::getAllPages();

$app = new App();

echo $app->render('admin/list-models.html', [
	'pages' => $pages,
	'menu_items' => $menuItems
]);
