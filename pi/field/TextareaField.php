<?php

namespace Pi\Field;

use Pi\Lib\Html;

class TextareaField extends BaseField {
	public $placeholder;
	public $minLength;
	public $maxLength;

	public function __construct($name, $infos) {
		parent::__construct($name, $infos);

		$this->placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
		$this->minLength   = isset($field['minLength'])   ? $field['minLength']   : 0;
		$this->maxLength   = isset($field['maxLength'])   ? $field['maxLength']   : false;
	}

	public function html() {
		return Html::tag('textarea', [
			'type' => 'text',
			'name' => $this->name
		], $this->value());
	}
}
