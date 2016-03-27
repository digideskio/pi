<?php

const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

define('PI_DIR_SITE', dirname(__FILE__) . DS);
define('PI_DIR_CONTENT', PI_DIR_SITE . 'content/');
define('PI_DIR_MODELS', PI_DIR_CONTENT . 'models/');
define('PI_DIR_PAGES', PI_DIR_CONTENT . 'pages/');
define('PI_DIR_THEMES', PI_DIR_CONTENT . 'themes/');

define('PI_URL_SITE', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/');
define('PI_URL_CONTENT', PI_URL_SITE . 'content/');
define('PI_URL_MODELS', PI_URL_CONTENT . 'models/');
define('PI_URL_PAGES', PI_URL_CONTENT . 'pages/');
define('PI_URL_THEMES', PI_URL_CONTENT . 'themes/');
