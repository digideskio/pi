<?php

require 'init.php';

use Pi\Core\Page\Page;
use Pi\Core\Model\Form;

if (!isset($_GET['page']))
	throw new Exception('Please give a page parameter to edit');

$page = $_GET['page'];

$page = Page::getLastVersion($page);

$models = $app->getModels();

$model = $models[$page->getModel()];

$form = new Form($model);

echo $app->render('@theme/admin/edit-page.html', [
	'menu_items' => $menuItems,
	'form' => $form->html()
]);
