<?php

namespace Pi\Core;

class Form {
	public $model;

	public function __construct($model, $bind = false) {
		$this->model = $model;
	}

	public function html() {
		$html  = '<form method="post" action="">';
		$html .= '<h1>Formulaire &laquo; ' . $this->model->title . ' &raquo;</h1>';
		$html .= '<div class="row">';

		$html .= '<input type="hidden" name="model" value="' . $this->model->slug . '" />';

		$accum = 0;

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

			// L'accumulateur sert à déterminer les lignes pour garder un affichage
			// propre (en grille)
			$accum += (int) substr($width, 7);

			if ($accum >= 12) {
				$html .= '</div>';
				$html .= '<div class="row">';
				$accum = 0;
			}
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
