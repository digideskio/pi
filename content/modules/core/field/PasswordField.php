<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
use Pi\Lib\Html\Tag;

class PasswordField extends BaseField {
	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);
	}

	/**
	 * @inheritdoc
	 */
	public function validate() {
		$value = $this->value();

		if ($this->required || !empty($value))
			return Num::between($this->min, $this->max, strlen($value));
		else
			return true;
	}

	/**
	 * @inheritdoc
	 */
	public function html() {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'password',
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
