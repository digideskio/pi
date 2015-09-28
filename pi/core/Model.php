<?php

namespace Pi\Core;

use Pi\Lib\Yaml;

class Model {
	public $file;
	public $title;
	public $fields;
	public $slug;

	public function __construct($file, $bind = false) {
		$model = Yaml::read($file);

		$this->file   = $file;
		$this->title  = $model['title'];
		$this->fields = [];
		$this->slug   = explode('/', $file)[2];

		foreach ($model['fields'] as $name => $field) {
			$class = ucfirst($field['type']) . 'Field';
			$class = 'Pi\\Core\\Field\\' . $class;

			$field['name'] = $name;

			$this->fields[] = new $class($field);
		}
	}
}
