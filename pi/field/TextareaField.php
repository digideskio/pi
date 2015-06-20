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
		$attr = [
			'type' => 'text',
			'name' => $this->name
		];

		if ($this->required)
			$attr['required'] = 'required';

		return Html::tag('textarea', $attr, $this->value());
	}
}
