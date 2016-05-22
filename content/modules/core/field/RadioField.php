<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
use Pi\Lib\Html\Tag;

class RadioField extends BaseField {
	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);

		if (count($this->options))
			$this->default = array_keys($this->options)[0];
	}

	/**
	 * @inheritdoc
	 */
	public function value() {
		if (!empty($_POST)) {
			if (isset($_POST[$this->name]))
				return $_POST[$this->name];
			else
				return '-';
		} else {
			return $this->default;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function html() {
		$html = '';

		$val = $this->value();

		foreach ($this->options as $key => $value) {
			$tag = new Tag('input', [
				'type'  => 'radio',
				'name'  => $this->name,
				'value' => $key,
				'id'    => 'input-' . $this->id
			]);

			if ($this->required)
				$tag->addAttr('required');

			if ($key == $val)
				$tag->addAttr('checked');

			$html .= $tag . ' <label for="input-' . $this->id . '">' . $value . '</label>';

			$this->id = ++self::$num;
		}

		return $html;
	}
}
