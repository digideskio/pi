<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class UserField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'text',
			'value' => $this->value()
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
