<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class RangeField extends BaseField {
	public $min;
  public $max;
  public $step;

	public function __construct($data) {
		parent::__construct($data);

		$this->min  = isset($data['min'])  ? $data['min']  : 0;
		$this->max  = isset($data['max'])  ? $data['max']  : 100;
		$this->step = isset($data['step']) ? $data['step'] : 1;
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : $this->default;
	}

	public function html() {
    $tag = new Tag('input', [
			'name'  => $this->name,
      'type'  => 'range',
      'min'   => $this->min,
      'max'   => $this->max,
      'step'  => $this->step,
      'value' => $this->value()
    ]);

    return $tag;
	}
}
