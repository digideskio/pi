<?php

// Constantes
const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

// Fichiers nécessaires au fonctionnement de l'application
require 'pi/vendors/Twig/Autoloader.php';
require 'pi/vendors/spyc/Spyc.php';
require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';
require 'pi/pi.php';

// Auto-chargement des classes
Twig_Autoloader::register();
Pi\App::register();

// Lancement de l'application (affichage de la page demandée)
$app = new Pi\App();
$app->run();
