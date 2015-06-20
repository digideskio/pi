<?php

namespace Pi\Field;

use Pi\Lib\Html;

class CheckboxesField extends BaseField {
	public $options;
	public $min;
	public $max;

	public function __construct($data) {
		parent::__construct($data);

		$this->options = isset($data['options']) ? $data['options'] : [];
		$this->min     = isset($data['min'])     ? $data['min']     : 0;
		$this->max     = isset($data['max'])     ? $data['max']     : false;
	}

	public function validate() {
		return is_array($this->value());
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : [];
	}

	public function html() {
		$html = '';

		foreach ($this->options as $key => $value) {
			$attr = [
				'type'  => 'checkbox',
				'name'  => $this->name . '[]',
				'value' => $key
			];

			if ($this->required)
				$attr['required'] = 'required';

			$html .= Html::tag('input', $attr) . ' ' . $value;
		}

		return $html;
	}
}
