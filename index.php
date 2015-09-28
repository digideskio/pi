<?php

const DS  = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

spl_autoload_register(function($class) {
	$el   = explode('\\', $class);
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
		throw new Exception('Le fichier &laquo; ' . $file . ' &raquo; n\'existe pas.');
});

require 'pi/vendors/spyc/Spyc.php';

require 'pi/vendors/parsedown/Parsedown.php';
require 'pi/vendors/parsedown/ParsedownExtra.php';

try {
	require 'pi/pi.php';
} catch (Exception $e) {
	echo '<pre>';
	echo $e->getMessage();
	echo '<br /><br />';
	echo $e->getTraceAsString();
	echo '</pre>';
}
