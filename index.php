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

$app = new Pi\App();

$app->run();
