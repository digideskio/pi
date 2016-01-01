<?php

$app->get('site.home', '/', function($app) {
	return $app->render('site/home.html');
});
