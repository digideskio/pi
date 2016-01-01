<?php

use Pi\Lib\Yaml;

$app->get('site.content', '(\d+)', function($app, $id) {
	$file = 'content/pages/' . $id . '.yaml';

	if (!file_exists($file))
		$app->redirect('GET site.home');

	$content = Yaml::read($file);

	$model = $content['model'];
	$fields = $content['fields'];

	echo $app->render($model . '/view.html', $fields);
});
