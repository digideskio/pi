<?php

namespace Pi\Field;

use Pi\Lib\Html;

class TextField extends BaseField {
	public function __construct($name) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';
	}

	public function html() {
		return Html::tag('input', [
			'type'  => 'text',
			'name'  => $this->name,
			'value' => $this->value()
		]);
	}
}
