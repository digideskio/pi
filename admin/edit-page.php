<?php

require 'init.php';

use Pi\Core\App;
use Pi\Model\Model;
use Pi\Page\Page;
use Pi\Lib\Json;

if (!isset($_GET['page']))
	throw new Exception('Please give a page parameter to edit');

$page = $_GET['page'];

$page = Page::getLastVersion($page);

$json = Json::decode('');
$model = Model::fromArray($page['model']);

$app = new App();

echo $app->render('admin/edit-page.html', [
	'menu_items' => $menuItems,
	'form' => $model->getForm()
]);
