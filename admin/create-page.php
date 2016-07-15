<?php

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

		mkdir(PI_DIR_PAGES . $slug);

		$page = new Page();
		$page->setTitle($title);
		$page->setModel($model);
		$page->setCreatedAt(new DateTime());
		$page->setUpdatedAt(new DateTime());

		$page->saveToFile(PI_DIR_PAGES . $slug . '/' . time() . '.json');

		header('Location: ' . PI_URL_SITE . 'admin/edit-page.php?page=' . $slug);
	}
}

$models = $app->getModels();

echo $app->render('@theme/admin/create-page.html', [
	'menu_items' => $menuItems,
	'models' => $models
]);
