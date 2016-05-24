<?php

namespace Module\Sample;

use Pi\Core\App;
use Module\Core\Field\TextField;

// Créer un nouveau modèle
App::registerModel(
	'test',
	__DIR__ . DS . 'add-model' . DS . 'model.json',
	__DIR__ . DS . 'add-model' . DS . 'view.html');

// Créer un nouveau champ
App::registerField(
	'test',
	MyTestField::class);

// Surcharger un modèle
App::overrideModel(
	'all',
	__DIR__ . DS . 'override-model' . DS . 'all.json',
	__DIR__ . DS . 'override-model' . DS . 'all.html');

// Surcharger la vue d'un modèle
App::overrideViewModel(
	'all',
	__DIR__ . DS . 'override-view-model' . DS . 'all.html');

// Surcharger un champ
App::overrideField(
	'text',
	MyTextField::class);

class MyTestField extends TextField { }
class MyTextField extends TextField { }
