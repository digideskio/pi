<?php

namespace Pi\Field;

use Pi\Lib\Html;

class TextField extends BaseField {
	public function __construct($name, $infos) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';

		$this->label = $infos['label'];
	}

	public function html() {
		return Html::tag('input', [
			'type'  => 'text',
			'name'  => $this->name,
			'value' => $this->value()
		]);
	}
}
