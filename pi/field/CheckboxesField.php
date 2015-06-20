<?php

namespace Pi\Field;

use Pi\Lib\Html;
use Pi\Lib\Html\Tag;

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
			$tag = new Tag('input', [
				'type'  => 'checkbox',
				'name'  => $this->name . '[]',
				'value' => 'dev'
			]);

			if ($this->required)
				$tag->addAttr('required');

			$html .= $tag . ' ' . $value;
		}

		return $html;
	}
}
