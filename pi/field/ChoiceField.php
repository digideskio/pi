<?php

namespace Pi\Field;

class ChoiceField extends BaseField {
	protected $options;

	public function __construct($name) {
		$this->name         = $name;
		$this->defaultValue = 'defaultValue';
		
		$this->options = [
			'design'      => 'Design',
			'programming' => 'Programmation'
		];
	}

	public function html() {
		$html = '<select name="' . $this->name . '">';

		foreach ($this->options as $key => $value)
			$html .= '<option value="' . $key . '">' . $value . '</option>';

		$html .= '</select>';

		return $html;
	}
}
