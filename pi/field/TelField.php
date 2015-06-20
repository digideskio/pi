<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class TelField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'tel',
			'value' => $this->value()
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
