<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class DateField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);

		if ($this->default == 'today')
			$this->default = strftime('%Y-%m-%d', time());
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'date',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
