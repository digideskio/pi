<?php

namespace Pi\Field;

class ChoiceField extends BaseField {
	public $options;

	public function __construct($data) {
		parent::__construct($data);

		$this->options = isset($data['options']) ? $data['options'] : [];
	}

	public function html() {
		$val = $this->value();

		$html = '<select name="' . $this->name . '"' . ($this->required ? ' required' : '') . '>';

		foreach ($this->options as $key => $value) {
		 	$selected = $key == $val ? ' selected' : '';

			$html .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}

		$html .= '</select>';

		return $html;
	}
}
