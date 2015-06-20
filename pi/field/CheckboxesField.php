<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class CheckboxesField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);

		$this->default = isset($data['default']) ? $data['default'] : [];
	}

	public function validate() {
		return is_array($this->value());
	}

	public function value() {
		if (!empty($_POST)) {
			if (isset($_POST[$this->name]))
				return $_POST[$this->name];
			else
				return [];
		} else {
			return $this->default;
		}
	}

	public function html() {
		$values = $this->value();

		$html = '';

		foreach ($this->options as $key => $value) {
			$tag = new Tag('input', [
				'type'  => 'checkbox',
				'name'  => $this->name . '[]',
				'value' => $key
			]);

			if ($this->required)
				$tag->addAttr('required');

			if (in_array($key, $values))
				$tag->addAttr('checked');

			$html .= $tag . ' ' . $value;
		}

		return $html;
	}
}
