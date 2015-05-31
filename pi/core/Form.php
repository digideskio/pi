<?php

namespace Pi\Core;

class Form {
	public $model;
	public $fields;

	public function __construct($model) {
		$this->model  = $model;
		$this->fields = [];

		foreach ($this->model['fields'] as $name => $field) {
			$class = ucfirst($field['type']) . 'Field';
			$class = 'Pi\Field\\' . $class;

			$this->fields[] = new $class($name);
		}
	}

	public function html() {
		$html = '<form method="post" action="">';

		foreach ($this->fields as $name => $field) {
			$html .= $field->html();
			$html .= '<br /><br />';
		}

		$html .= '<input type="submit" value="Valider" />';

		$html .= '</form>';

		return $html;
	}

	public function validate() {
		$errors = [];

		foreach ($this->fields as $field)
			array_push($errors, $field->validate());

		return $errors;
	}
}
