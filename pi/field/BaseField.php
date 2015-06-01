<?php

namespace Pi\Field;

class BaseField {
	public $name;
	public $label;
	public $default;
	public $required;

	public function __construct($name, $field) {
		$this->name = $name;

		$this->label    = isset($field['label'])    ? $field['label']    : '';
		$this->default  = isset($field['default'])  ? $field['default']  : '';
		$this->required = isset($field['required']) ? $field['required'] : '';
	}

	public function html() {
		return '';
	}

	public function validate() {
		return !empty($this->value());
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : '';
	}

	public function save() {
		return $this->value();
	}
}
