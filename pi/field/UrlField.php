<?php

namespace Pi\Field;

use Pi\Lib\Html\Tag;

class UrlField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);
	}

	public function validate() {
		$value = $this->value();
		$regex = '~^(https?|ftp)://[^\s/$.?#].[^\s]*$~i~';

		if ($this->required) {
			if (preg_match($regex, $value))
				return true;
			else
				return false;
		} else {
			if (empty($value))
				return true;
			else if (preg_match($regex, $value))
				return true;
			else
				return false;
		}
	}

	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'url',
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
