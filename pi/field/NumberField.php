<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class NumberField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'number',
			'value' => $this->value(),
			'min'   => $this->min,
			'max'   => $this->max,
			'step'  => $this->step
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
