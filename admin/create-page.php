<?php

require 'init.php';

echo $app->render('@theme/admin/create-page.html', [
	'menu_items' => $menuItems
]);
