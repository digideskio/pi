<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;

class ChoiceField extends BaseField {
	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);
	}

	/**
	 * @inheritdoc
	 */
	public function html() {
		$val = $this->value();

		$html = '<select name="' . $this->name . '"' . ($this->required ? ' required' : '') . ' id="input-' . $this->id . '">';

		foreach ($this->options as $key => $value) {
		 	$selected = $key == $val ? ' selected' : '';

			$html .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}

		$html .= '</select>';

		return $html;
	}
}
