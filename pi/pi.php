<?php

namespace Pi;

use Pi\Core\Form;
use Pi\Lib\Yaml;

$model = Yaml::read('content/models/all.yaml');

$form = new Form($model);

echo $form->html();

if (!empty($_POST)) {
	$valid = !in_array(false, $form->validate());

	echo '<pre>';
	var_dump($form->validate());
	var_dump($form->save());
	echo '</pre>';

	if ($valid)
		Yaml::write(time() . '.yaml', $form->save());
}
