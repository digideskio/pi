<?php

use Pi\Lib\Yaml;

$app->get('site.home', '/', function($app) {
	return $app->render('site/home.html');
});

$app->get('site.content', '(\d+)', function($app, $id) {
	$content = Yaml::read('content/pages/' . $id . '.yaml');

	$model = $content['model'];
	$fields = $content['fields'];

	echo $app->render($model . '/view.html', $fields);
});
