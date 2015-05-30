<?php

namespace Pi\Field;

class CheckboxesField extends BaseField {
	protected $options;

	public function __construct($name) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';
		
		$this->options = [
			'design'      => 'Design',
			'programming' => 'Programmation'
		];
	}

	public function validate() {
		return true;
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
