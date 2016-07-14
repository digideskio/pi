<?php

/**
 * This file is part of Pi.
 *
 * Pi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Pi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Pi.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Pi\Core\Model;

class Form {
	/** @var Model */
	private $model;

	/**
	 * @param $model Modèle
	 */
	public function __construct(Model $model) {
		$this->model = $model;
	}

	/**
	 * @return Formulaire au format HTML
	 */
	public function html(): string {
		$html  = '<form method="post" action="">';
		$html .= '<h1>Formulaire &laquo; ' . $this->model->getTitle() . ' &raquo;</h1>';
		$html .= '<div class="row">';

		$html .= '<input type="hidden" name="model" value="' . $this->model->getSlug() . '" />';

		$html .= '<input type="text" name="title" value="todo" />';

		$accum = 0;

		foreach ($this->model->getFields() as $field) {
			$width = $this->getCssClassFromWidth($field->width);
			$html .= $this->getHtmlFromField($field);

			// L'accumulateur sert à déterminer les lignes pour garder un
			// affichage propre (en grille)
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

	/**
	 * @return Champs incorrects
	 */
	public function validate(): array {
		$errors = [];

		foreach ($this->model->getFields() as $field)
			$errors[$field->name] = $field->validate();

		return $errors;
	}

	/**
	 * @return Tableau avec les valeurs
	 */
	public function save(): array {
		$infos = [];

		foreach ($this->model->getFields() as $field)
			$infos[$field->name] = $field->save();

		return $infos;
	}

	/**
	 * Génère le HTML d'un champ donné
	 *
	 * @param $field Champ
	 *
	 * @return Code HTML du champ
	 */
	private function getHtmlFromField(Field $field): string {
		$html = '';

		$width = $this->getCssClassFromWidth($field->width);

		$html .= '<div class="' . $width . '">';
		$html .= '<label for="input-' . $field->id . '">' . $field->label;

		if ($field->required)
			$html .= ' *';

		$html .= '</label><br />';

		if (!empty($field->message))
			$html .= '<small>' . $field->message . '</small><br />';

		$html .= $field->html();
		$html .= '</div>';

		return $html;
	}

	/**
	 * Classe CSS à utiliser en fonction de la taille du champ donné
	 *
	 * @param $width Largeur (1/2, 1/3, 2/3, 1/4 ou 3/4)
	 *
	 * @return Classe CSS à utiliser pour la largeur du champ
	 */
	private function getCssClassFromWidth(string $width): string {
		switch ($width) {
			case '1/2': $width = 'col-xs-6'; break;
			case '1/3': $width = 'col-xs-4'; break;
			case '2/3': $width = 'col-xs-8'; break;
			case '1/4': $width = 'col-xs-3'; break;
			case '3/4': $width = 'col-xs-9'; break;
			default:    $width = 'col-xs-12';
		}

		return $width;
	}
}
