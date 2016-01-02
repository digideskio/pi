<?php

const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

try {
	require 'pi/vendors/Twig/Autoloader.php';
	require 'pi/vendors/spyc/Spyc.php';
	require 'pi/vendors/parsedown/Parsedown.php';
	require 'pi/vendors/parsedown/ParsedownExtra.php';

	require 'pi/pi.php';

	Pi\App::register();
	Twig_Autoloader::register();

	$app = new Pi\App();

	require 'pi/modules/site/home.php';
	require 'pi/modules/admin/home.php';
	require 'pi/modules/admin/models/create.php';
	require 'pi/modules/admin/models/edit.php';
	require 'pi/modules/admin/models/home.php';
	require 'pi/modules/admin/models/import.php';
	require 'pi/modules/admin/models/remove.php';
	require 'pi/modules/admin/models/use.php';
	require 'pi/modules/admin/pages/create.php';
	require 'pi/modules/site/content.php';

	$app->run();
} catch (Exception $e) {
	echo '<pre>';
	echo $e->getMessage();
	echo '<br /><br />';
	echo $e->getTraceAsString();
	echo '</pre>';
}
