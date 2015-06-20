<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class NumberField extends BaseField {
	public $minLength;
	public $maxLength;

	public function __construct($data) {
		parent::__construct($data);

		$this->minLength = isset($data['minLength']) ? $data['minLength'] : 0;
		$this->maxLength = isset($data['maxLength']) ? $data['maxLength'] : false;

		$this->min  = isset($data['min'])  ? $data['min']  : 0;
		$this->max  = isset($data['max'])  ? $data['max']  : 100;
		$this->step = isset($data['step']) ? $data['step'] : 1;
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
