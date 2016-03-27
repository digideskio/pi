<?php

// Constantes
require 'constants.php';

// Fichiers nécessaires au fonctionnement de l'application
require 'pi/vendors/Twig/Autoloader.php';
require 'pi/vendors/spyc/Spyc.php';
require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';
require 'pi/App.php';

// Auto-chargement des classes
Twig_Autoloader::register();
Pi\App::register();
