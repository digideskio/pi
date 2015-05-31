<?php

namespace Pi\Field;

use Pi\Lib\Html;

class TextareaField extends BaseField {
	public function __construct($name, $infos) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';

		$this->label = $infos['label'];
	}

	public function html() {
		return Html::tag('textarea', [
			'type' => 'text',
			'name' => $this->name
		], $this->value());
	}
}
