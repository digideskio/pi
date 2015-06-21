<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class RadioField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function value() {
		if (!empty($_POST)) {
			if (isset($_POST[$this->name]))
				return $_POST[$this->name];
			else
				return '-';
		} else {
			return $this->default;
		}
	}

	public function html() {
		$html = '';

		$val = $this->value();

		var_dump($val);

		foreach ($this->options as $key => $value) {
			$tag = new Tag('input', [
				'type'  => 'radio',
				'name'  => $this->name,
				'value' => $key,
				'id'    => 'input-' . $this->id
			]);

			if ($this->required)
				$tag->addAttr('required');

			if ($key == $val)
				$tag->addAttr('checked');

			$html .= $tag . ' <label for="input-' . $this->id . '">' . $value . '</label>';

			$this->id = ++self::$num;
		}

		return $html;
	}
}
