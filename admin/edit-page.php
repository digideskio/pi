<?php

require 'init.php';

use Pi\Core\Page\Page;
use Pi\Lib\Json;
use Pi\Core\Model\Model;

if (!isset($_GET['page']))
	throw new Exception('Please give a page parameter to edit');

$page = $_GET['page'];

$page = Page::getLastVersion($page);

$model = Model::fromArray($page->model);

echo $app->render('@theme/admin/edit-page.html', [
	'menu_items' => $menuItems,
	'form' => $model->getForm()
]);
