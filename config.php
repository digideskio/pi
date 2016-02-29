<?php

// Constantes
const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

define('PI_DIR', dirname(__FILE__) . DS);
define('PI_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/');

// Fichiers nécessaires au fonctionnement de l'application
require 'pi/vendors/Twig/Autoloader.php';
require 'pi/vendors/spyc/Spyc.php';
require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';
require 'pi/App.php';

// Auto-chargement des classes
Twig_Autoloader::register();
Pi\App::register();
