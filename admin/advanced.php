<?php

require 'init.php';

use Pi\Core\Page\PageCollection;

$pages = PageCollection::getAllPages();

echo $app->render('@theme/admin/advanced.html', [
	'pages' => $pages,
	'menu_items' => $menuItems
]);
