<?php

require_once 'pi/vendors/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('index.html');
