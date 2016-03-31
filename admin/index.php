<?php

require '../settings.php';

use Pi\App;
use Pi\PageCollection;

session_start();

function isConnected() {
    return isset($_SESSION['username']);
}

$_SESSION['username'] = 'super-admin';

$pages = PageCollection::getAllPages();

$app = new App();

echo $app->render('admin/list-pages.html', [
    'pages' => $pages
]);
