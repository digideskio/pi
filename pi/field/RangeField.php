<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class RangeField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
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
