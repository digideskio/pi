<?php

namespace Pi\Core\Field;

use Pi\Lib\Html\Tag;

class RangeField extends BaseField {
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
      'type'  => 'range',
      'min'   => $this->min,
      'max'   => $this->max,
      'step'  => $this->step,
      'value' => $this->value(),
			'id'    => 'input-' . $this->id
    ]);

    return $tag;
	}
}
