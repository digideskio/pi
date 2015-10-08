<?php

namespace Pi\Core\Field;

use Pi\Lib\Html\Tag;

class TextareaField extends BaseField {
	private static $formats = [ 'text', 'markdown', 'json', 'ini', 'yaml', 'cson', 'xml' ];

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

		if ($this->min > 0 && $this->min <= $this->max)
			$tag->addAttr('minlength', $this->min);

		if ($this->max > 0 && $this->max >= $this->min)
			$tag->addAttr('maxlength', $this->max);

		return $tag;
	}
}