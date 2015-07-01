<?php

namespace Pi\Core\Field;

use Pi\Lib\Str;
use Pi\Lib\Html\Tag;

class SlugField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function validate() {
		$value = $this->value();

		if ($this->required || !empty($value))
			return $value == Str::slug($value);
		else
			return true;
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'text',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

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
