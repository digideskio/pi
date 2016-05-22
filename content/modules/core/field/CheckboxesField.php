<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
use Pi\Lib\Num;
use Pi\Lib\Html\Tag;

class CheckboxesField extends BaseField {
	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);

		$this->default = isset($data['default']) ? $data['default'] : [];
	}

	/**
	 * @inheritdoc
	 */
	public function validate() {
		$values = $this->value();

		if ($this->required && is_array($values))
			return Num::between($this->min, $this->max, count($values));
		else
			return is_array($values);
	}

	/**
	 * @inheritdoc
	 */
	public function value() {
		if (!empty($_POST)) {
			if (isset($_POST[$this->name]))
				return $_POST[$this->name];
			else
				return [];
		} else {
			return $this->default;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function html() {
		$values = $this->value();

		$html = '';

		foreach ($this->options as $key => $value) {
			$tag = new Tag('input', [
				'type'  => 'checkbox',
				'name'  => $this->name . '[]',
				'value' => $key,
				'id'    => 'input-' . $this->id
			]);

			if ($this->required)
				$tag->addAttr('required');

			if (in_array($key, $values))
				$tag->addAttr('checked');

			$html .= $tag . ' <label for="input-' . $this->id . '">' . $value . '</label>';

			$this->id = ++self::$num;
		}

		return $html;
	}
}
