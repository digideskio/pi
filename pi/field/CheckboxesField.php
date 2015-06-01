<?php

namespace Pi\Field;

class CheckboxesField extends BaseField {
	public $options;
	public $min;
	public $max;

	public function __construct($name, $infos) {
		parent::__construct($name, $infos);

		$this->options = $infos['options'];
		$this->min     = isset($field['min']) ? $field['min'] : 0;
		$this->max     = isset($field['max']) ? $field['max'] : false;
	}

	public function validate() {
		return is_array($this->value());
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : [];
	}

	public function html() {
		$html = '';

		foreach ($this->options as $key => $value)
			$html .= '<input type="checkbox" name="' . $this->name . '[]" value="' . $key . '" /> ' . $value;

		$html .= '</select>';

		return $html;
	}
}
