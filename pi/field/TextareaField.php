<?php

namespace Pi\Field;

use Pi\Lib\Html;

class TextareaField extends BaseField {
	public function __construct($name) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';
	}

	public function html() {
		return Html::tag('textarea', [
			'type' => 'text',
			'name' => $this->name
		], $this->value());
	}
}
