<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class NumberField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);

		$this->min  = isset($data['min'])  ? $data['min']  : 0;
		$this->max  = isset($data['max'])  ? $data['max']  : 100;
		$this->step = isset($data['step']) ? $data['step'] : 1;
	}

	public function value() {
		return (int) parent::value();
	}

	public function validate() {
		$value = $this->value();

		if ($this->required || !empty($value))
			return Num::between($this->min, $this->max, $value);
		else
			return true;
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'number',
			'value' => $this->value(),
			'min'   => $this->min,
			'max'   => $this->max,
			'step'  => $this->step,
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
