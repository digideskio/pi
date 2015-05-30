<?php

define('DS', DIRECTORY_SEPARATOR);

spl_autoload_register(function($class) {
	$el = explode('\\', $class);

	$file = __DIR__;

	end($el);
	$lastElementKey = key($el);

	foreach ($el as $k => $e)
		if ($k == $lastElementKey)
			$file .= DS . $e;
		else
			$file .= DS . strtolower($e);

	$file .= '.php';

	if (file_exists($file))
		require $file;
	else
		throw new Exception('Le fichier "' . $file . '" n\'existe pas.');
});

require 'pi/vendors/spyc/Spyc.php';

require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';

require 'pi/pi.php';
