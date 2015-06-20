<?php

namespace Pi;

use Pi\Core\Form;
use Pi\Lib\Yaml;

$model = Yaml::read('content/models/exists.yaml');

$form = new Form($model);

echo $form->html();

if (!empty($_POST)) {
	echo '<pre>';
	var_dump($form->validate());

	Yaml::write(time() . '.yaml', $form->save());

	echo '</pre>';
}
