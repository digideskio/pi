<?php

namespace Pi\Field;

class ChoiceField extends BaseField {
	public $options;

	public function __construct($name, $infos) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';

		$this->label   = $infos['label'];
		$this->options = $infos['options'];
	}

	public function html() {
		$html = '<select name="' . $this->name . '">';

		foreach ($this->options as $key => $value)
			$html .= '<option value="' . $key . '">' . $value . '</option>';

		$html .= '</select>';

		return $html;
	}
}
