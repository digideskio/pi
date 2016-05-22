<?php

namespace Module\Sample;

use Pi\Core\App;
use Module\Core\Field\TextField;

// Créer un nouveau modèle
App::registerModel(
	'test',
	dirname(__FILE__) . DS . 'add-model' . DS . 'model.json',
	dirname(__FILE__) . DS . 'add-model' . DS . 'view.html');

// Créer un nouveau champ
App::registerField(
	'test',
	MyTestField::class);

// Surcharger un modèle
App::overrideModel(
	'all',
	dirname(__FILE__) . DS . 'override-model' . DS . 'all.json',
	dirname(__FILE__) . DS . 'override-model' . DS . 'all.html');

// Surcharger la vue d'un modèle
App::overrideViewModel(
	'all',
	dirname(__FILE__) . DS . 'override-view-model' . DS . 'all.html');

// Surcharger un champ
App::overrideField(
	'text',
	MyTextField::class);

class MyTestField extends TextField { }
class MyTextField extends TextField { }
