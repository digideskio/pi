<?php

namespace Pi\Field;

use Pi\Lib\Html;

class TextareaField extends BaseField {
	public $placeholder;
	public $minLength;
	public $maxLength;

	public function __construct($data) {
		parent::__construct($data);

		$this->placeholder = isset($data['placeholder']) ? $data['placeholder'] : '';
		$this->minLength   = isset($data['minLength'])   ? $data['minLength']   : 0;
		$this->maxLength   = isset($data['maxLength'])   ? $data['maxLength']   : false;
	}

	public function html() {
		return Html::tag('textarea', [
			'type' => 'text',
			'name' => $this->name
		], $this->value());
	}
}
