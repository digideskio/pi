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

		$html .= '<div class="row">';

		foreach ($this->fields as $name => $field) {
			switch ($field->width) {
				case '1/2':
					$width = 'col-xs-6'; break;

				case '1/3':
					$width = 'col-xs-4'; break;

				case '2/3':
					$width = 'col-xs-8'; break;

				case '1/4':
					$width = 'col-xs-3'; break;

				case '3/4':
					$width = 'col-xs-9'; break;

				default:
					$width = 'col-xs-12';
			}

			$html .= '<div class="' . $width . '">';

			$html .= '<label for="input-' . $field->id . '">' . $field->label;

			if ($field->required)
				$html .= ' *';

			$html .= '</label><br />';

			if (!empty($field->message))
				$html .= '<small>' . $field->message . '</small><br />';

			$html .= $field->html();

			$html .= '</div> ';
		}

		$html .= '</div>';

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
