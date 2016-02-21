<?php

const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

require 'pi/vendors/Twig/Autoloader.php';
require 'pi/vendors/spyc/Spyc.php';
require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';
require 'pi/pi.php';

Pi\App::register();
Twig_Autoloader::register();

use Pi\Core\Page;
use Pi\Lib\Markdown;

$path = 'home';

if (isset($_SERVER['PATH_INFO']))
	$path = $_SERVER['PATH_INFO'];

if (empty($path))
	$path = 'home';

$page = Page::getLastVersion($path);

$loader = new Twig_Loader_Filesystem('./content/themes/default/tpl');
$loader->addPath('./content/models');
$twig = new Twig_Environment($loader);
$twig->addExtension(new Twig_Extension_StringLoader());

$twig->addFilter(new Twig_SimpleFilter('markdown', function($text) {
	return Markdown::html($text);
}, [ 'is_safe' => [ 'html' ] ]));



$content = Page::getLastVersion($path);

if (!$content)
	$content = Page::getLastVersion('error');

$model = $content['model'];
$fields = $content['fields'];

$meta = [
	'model' => $model,
	'created_at' => $content['created_at'],
	'updated_at' => $content['updated_at']
];

$variables = [
	'page' => $fields,
	'meta' => $meta
];

echo $twig->render($model . '/view.html', $variables);
