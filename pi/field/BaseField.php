<?php

namespace Pi\Field;

abstract class BaseField {
	public $name;
	public $label;
	public $default;
	public $required;

	public function __construct($data) {
		$this->name     = isset($data['name'])     ? $data['name']     : '';
		$this->label    = isset($data['label'])    ? $data['label']    : '';
		$this->default  = isset($data['default'])  ? $data['default']  : '';
		$this->required = isset($data['required']) ? $data['required'] : '';
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
