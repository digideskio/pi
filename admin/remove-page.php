<?php

require 'init.php';

use Pi\Core\Page\Page;
use Pi\Core\Model\Form;

if (!isset($_GET['page']))
	throw new Exception('Please give a page parameter to edit');

$pageSlug = $_GET['page'];

if ($pageSlug) {
	$page = $app->getPagesRepository()->findBySlug($pageSlug);

	if ($page) {
		$app->getPagesRepository()->remove($page);

		header('Location: ' . PI_URL_SITE . 'admin/list-pages.php');
	}
}

header('Location: ' . PI_URL_SITE . 'admin/index.php');
