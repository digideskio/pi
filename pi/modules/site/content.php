<?php

use Pi\Lib\Yaml;
use Pi\Core\Page;

$app->get('site.content', '([a-zA-Z0-9/_-]*)', function($app, $slug) {
	$content = Page::getLastVersion($slug);

	try {
		$model = $content['model'];
		$fields = $content['fields'];

		echo $app->render($model . '/view.html', [
			'page' => $fields
		]);
	} catch (Exception $e) {
		return $app->redirect('GET site.home');
	}
});
