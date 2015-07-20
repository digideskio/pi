<?php

$app->get('site.home', '/', function($app) {
	$page = $app->view('site/views/home.php');

	return $page;
});
