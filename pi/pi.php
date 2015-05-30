<?php

namespace Pi;

use Pi\Lib\Yaml;
use Pi\Lib\Markdown;
use Pi\Core\Model;

$model = Yaml::read('models/exists.yaml');
$fields = $model['fields'];

foreach ($fields as $name => $field) {
	$class = ucfirst($field['type']) . 'Field';

	$class = 'Pi\Field\\' . $class;

	$f = new $class($name);

	echo $f->html();
}
