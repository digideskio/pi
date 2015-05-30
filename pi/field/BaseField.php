<?php

namespace Pi\Field;

abstract class BaseField {
	protected $name;
	protected $label;
	protected $defaultValue;

	public abstract function html();

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
