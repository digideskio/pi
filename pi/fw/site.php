<?php

$m = new App();

// Retour réponse HTTP
$m->get('site.home', '/', function (Context $ctx) {
	$myJson = '{ "a": 0 }';

	return new HttpResponse($myJson, [
		'contentType' => 'application/json', // défaut : text/html
		'statusCode' => 200 // défaut : 200
	]);
});

// Retour redirection
$m->get('site.home', '/', function (Context $ctx) {
	return new HttpRedirect('site.home');
});

// Retour réponse HTTP avec template
$m->get('site.home', '/', function (Context $ctx) {
	$page = new Template('ma-page.tpl', [
		'username' => 'essai'
	]);

	return new HttpResponse($page, [
		'contentType' => 'text/html', // défaut
		'statusCode' => 200 // défaut
	]);
});

// Récupération des paramètres
$m->get('user.profile', '/user/:id([0-9]+)', function (Context $ctx) {
	$id = $ctx->getParam('id');
});

$m->run();
