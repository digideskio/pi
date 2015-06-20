<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class UserField extends BaseField {
	public $minLength;
	public $maxLength;

	public function __construct($data) {
		parent::__construct($data);

		$this->minLength = isset($data['minLength']) ? $data['minLength'] : 0;
		$this->maxLength = isset($data['maxLength']) ? $data['maxLength'] : false;
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
