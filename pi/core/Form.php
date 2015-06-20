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
			$class = 'Pi\\Field\\' . $class;

			$field['name'] = $name;

			$this->fields[] = new $class($field);
		}
	}

	public function html() {
		$html = '<form method="post" action="">';

		$html .= '<h1>Formulaire &laquo; ' . $this->model['title'] . ' &raquo;</h1>';

		foreach ($this->fields as $name => $field) {
			$html .= '<label>' . $field->label . '</label><br />';
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
			$errors[$field->name] = $field->validate();

		return $errors;
	}

	public function save() {
		$infos = [];

		foreach ($this->fields as $field)
			$infos[$field->name] = $field->save();

		return $infos;
	}
}
