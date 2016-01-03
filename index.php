<?php

const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

$path = 'home';

if (isset($_SERVER['PATH_INFO'])) {
	// /page/test/&edit => page/test
	preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?.*/', $_SERVER['PATH_INFO'], $matches);
	$path = trim($matches[1], '/');
}

require 'pi/vendors/Twig/Autoloader.php';
require 'pi/vendors/spyc/Spyc.php';
require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';
require 'pi/pi.php';

Pi\App::register();
Twig_Autoloader::register();

use Pi\App;
use Pi\Core\Page;

$app = new App($path);

$content = Page::getLastVersion($path);

try {
	$model = $content['model'];
	$fields = $content['fields'];

	$meta = [
		'model' => $model,
		'created_at' => $content['created_at'],
		'updated_at' => $content['updated_at']
	];

	echo $app->render($model . '/view.html', [
		'page' => $fields,
		'meta' => $meta
	]);
} catch (Exception $e) {
	echo $app->render('site/error.html', [
		'code' => 404,
		'message' => 'Page inexistante.'
	]);
}
