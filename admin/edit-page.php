<?php

require 'init.php';

use Pi\Core\Page\Page;
use Pi\Core\Model\Form;

if (!isset($_GET['page']))
	throw new Exception('Please give a page parameter to edit');

$pageSlug = $_GET['page'];

if (isset($_POST)) {
	if (isset($_POST['model'])) {
		$model = $_POST['model'] ?? false;
		$title = $_POST['title'] ?? '';

		$page = new Page();
		$page->setTitle($title, false);
		$page->setModel($model);
		$page->setCreatedAt(new DateTime());
		$page->setUpdatedAt(new DateTime());
		$page->setFields([ 'content' => $_POST['content'] ]);

		$app->getPagesRepository()->save($page);

		header('Location: ' . PI_URL_SITE . 'admin/edit-page.php?page=' . $pageSlug);
	}
}

$page = $app->getPagesRepository()->findBySlug($pageSlug);

$models = $app->getModels();

$model = $models[$page->getModel()];

$form = new Form($model, $page);

echo $app->render('@theme/admin/edit-page.html', [
	'menu_items' => $menuItems,
	'form' => $form->html()
]);
