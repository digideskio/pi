<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class TextField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function validate() {
		$value = $this->value();

		if ($this->required || !empty($value))
			return Num::between($this->min, $this->max, strlen($value));
		else
			return true;
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'text',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
