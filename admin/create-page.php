<?php

declare(strict_types=1);

require 'init.php';

use Pi\Lib\Str;
use Pi\Core\Page\Page;

if (isset($_POST)) {
	if (isset($_POST['model'])) {
		$model = $_POST['model'] ?? false;
		$title = $_POST['title'] ?? '';
		$slug = Str::slug($title);

		if (empty($title))
			header('Location: ' . PI_URL_SITE);

		$page = new Page();
		$page->setTitle($title);
		$page->setModel($model);
		$page->setCreatedAt(new DateTime());
		$page->setUpdatedAt(new DateTime());

		$app->getPagesRepository()->save($page);

		header('Location: ' . PI_URL_SITE . 'admin/edit-page.php?page=' . $slug);
	}
}

$models = $app->getModels();

echo $app->render('@theme/admin-pages/create-page.html', [
	'menu_items' => $menuItems,
	'models' => $models
]);
