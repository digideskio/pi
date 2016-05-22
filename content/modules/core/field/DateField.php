<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
use Pi\Lib\Html\Tag;

class DateField extends BaseField {
	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);

		if ($this->default == 'today')
			$this->default = strftime('%Y-%m-%d', time());
	}

	/**
	 * @inheritdoc
	 */
	public function validate() {
		$value = $this->value();
		$regex = '~[0-9]{4}(-[0-9]{1,2}){2}~'; // yyyy-mm-dd

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

	/**
	 * @inheritdoc
	 */
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
