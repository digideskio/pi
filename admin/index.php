<?php

require 'init.php';

use Pi\Core\App;
use Pi\Page\PageCollection;

$pages = PageCollection::getAllPages();

$app = new App();

echo $app->render('admin/dashboard.html', [
	'pages' => $pages,
	'menu_items' => $menuItems
]);
