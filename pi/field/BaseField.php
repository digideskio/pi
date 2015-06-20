<?php

namespace Pi\Field;

abstract class BaseField {
	protected static $num = 0;

	public $name;
	public $label;
	public $default;
	public $required;
	public $placeholder;

	public function __construct($data) {
		self::$num++;

		$this->name        = isset($data['name'])        ? $data['name']        : '';
		$this->label       = isset($data['label'])       ? $data['label']       : '';
		$this->default     = isset($data['default'])     ? $data['default']     : '';
		$this->required    = isset($data['required'])    ? $data['required']    : false;
		$this->placeholder = isset($data['placeholder']) ? $data['placeholder'] : '';
	}

	public function html() {
		return '';
	}

	public function validate() {
		if ($this->required)
			return !empty($this->value());
		else
			return true;
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : $this->default;
	}

	public function save() {
		return $this->value();
	}
}
