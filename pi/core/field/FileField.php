<?php

namespace Pi\Core\Field;

use Pi\Lib\Html\Tag;

class FileField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'file',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		return $tag;
	}
}
