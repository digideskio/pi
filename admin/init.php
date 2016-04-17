<?php

require '../settings.php';

use Pi\Core\Settings;

session_start();

function isConnected() {
	return isset($_SESSION['username']);
}

$_SESSION['username'] = 'super-admin';

$user = Settings::getUser($_SESSION['username']);

$menuItems = [];

$menuItems['Tableau de bord'] = PI_URL_SITE . 'admin/';

if ($user->hasPermission('can-manage-pages'))
	$menuItems['Pages'] = PI_URL_SITE . 'admin/list-pages.php';

if ($user->hasPermission('can-manage-models'))
	$menuItems['Modèles'] = PI_URL_SITE . 'admin/list-models.php';

if ($user->hasPermission('can-manage-users'))
	$menuItems['Utilisateurs'] = PI_URL_SITE . 'admin/list-users.php';

if ($user->hasPermission('can-manage-settings'))
	$menuItems['Paramètres'] = PI_URL_SITE . 'admin/settings.php';

if ($user->hasPermission('can-manage-advanced'))
	$menuItems['Avancés'] = PI_URL_SITE . 'admin/advanced.php';
