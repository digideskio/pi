<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class TextareaField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function html() {
		$tag = new Tag('textarea', [
			'type' => 'text',
			'name' => $this->name,
			'id'    => 'input-' . $this->id
		], $this->value());

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
