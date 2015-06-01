<?php

namespace Pi\Field;

use Pi\Lib\Html;
use Pi\Field\BaseField;

class TextField extends BaseField {
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
		return Html::tag('input', [
			'type'  => 'text',
			'name'  => $this->name,
			'value' => $this->value()
		]);
	}
}
