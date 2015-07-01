<?php

namespace Pi\Core;

class Form {
	public $model;
	public $bind;

	public function __construct($model, $bind = false) {
		$this->model  = $model;

		$this->bind = $bind;
	}

	public function html() {
		if ($this->bind)
			call_user_func($this->bind, $this);

		$html  = '<form method="post" action="">';
		$html .= '<h1>Formulaire &laquo; ' . $this->model->title . ' &raquo;</h1>';
		$html .= '<div class="row">';

		foreach ($this->model->fields as $field) {
			switch ($field->width) {
				case '1/2': $width = 'col-xs-6'; break;
				case '1/3': $width = 'col-xs-4'; break;
				case '2/3': $width = 'col-xs-8'; break;
				case '1/4': $width = 'col-xs-3'; break;
				case '3/4': $width = 'col-xs-9'; break;
				default:    $width = 'col-xs-12';
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

		foreach ($this->model->fields as $field)
			$errors[$field->name] = $field->validate();

		return $errors;
	}

	public function save() {
		$infos = [];

		foreach ($this->model->fields as $field)
			$infos[$field->name] = $field->save();

		return $infos;
	}
}
