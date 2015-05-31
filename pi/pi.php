<?php

namespace Pi;

use Pi\Core\Form;
use Pi\Lib\Yaml;

$model = Yaml::read('models/exists.yaml');

$form = new Form($model);

echo $form->html();

if (!empty($_POST))
	var_dump($form->validate());
