<?php

declare(strict_types=1);

require 'init.php';

use Pi\Core\Model\Model;
use Pi\Core\Model\Form;

if (!isset($_GET['page']))
	throw new Exception('Please give a page parameter to edit');

$pageSlug = $_GET['page'];

$page = $app->getPagesRepository()->findBySlug($pageSlug);

if (isset($_POST)) {
	if (isset($_POST['model'])) {
		$model = $_POST['model'] ?? false;
		$title = $_POST['title'] ?? '';

		$fields = $_POST;
		unset($fields['model']);
		unset($fields['title']);

		$page->setTitle($title, false);
		$page->setFields($fields);
		$page->setUpdatedAt(new DateTime());

		$app->getPagesRepository()->save($page);

		header('Location: ' . PI_URL_SITE . 'admin/edit-page.php?page=' . $pageSlug);
	}
}

$models = $app->getModels();

/** @var Model $model */
$model = $models[$page->getModel()];
$model->fillFieldsWithPage($page);

$form = new Form($model, $page);

echo $app->render('@theme/admin/edit-page.html', [
	'menu_items' => $menuItems,
	'form' => $form->html()
]);
