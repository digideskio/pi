<?php

namespace Pi\Core;

use Pi\Lib\Yaml;

class Model {
	public $file;
	public $title;
	public $fields;
	public $slug;

	public function __construct($file) {
		$model = Yaml::read($file);
		
		$this->file = $file;
		$this->title = $model['title'];
		$this->fields = [];
		$this->slug = explode('/', $file)[2];

		$slug = str_replace(PI_DIR_MODELS, '', $file);

		var_dump($slug);

		foreach ($model['fields'] as $name => $field) {
			$class = ucfirst($field['type']) . 'Field';
			$class = 'Pi\\Core\\Field\\' . $class;

			$field['name'] = $name;

			$this->fields[] = new $class($field);
		}
	}
}
