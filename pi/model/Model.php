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

namespace Pi\Model;

use Exception;

use Pi\Lib\Str;

class Model {
	/** @var string Nom du modèle */
	protected $title;

	/** @var string Slug du modèle */
	protected $slug;

	/** @var Field[] Champs du modèle */
	protected $fields;

	/** @var string Vue du modèle */
	protected $viewFilename;

	/**
	 * Construit un modèle
	 *
	 * @param array $array
	 *
	 * @return static
	public static function fromArray($array) {
		$model = new Model($array['title']);

		foreach ($array['fields'] as $name => $field) {
			$fieldClass = App::getField($field['type']);

			$field['name'] = $name;

			$model->addField($name, $fieldClass::fromArray($field));
		}

		return $model;
	}
	*/

	/**
	 * Constructeur
	 *
	 * @param string $title Titre du modèle
	 */
	public function __construct($title = '') {
		$this->setTitle($title);

		$this->fields = [];
		$this->viewFilename = '';
	}

	/**
	 * Définit le titre du modèle
	 *
	 * @param string $title
	 * @param bool $overrideSlug
	 *
	 * @return $this
	 */
	public function setTitle($title, $overrideSlug = true) {
		$this->title = $title;

		if ($overrideSlug)
			$this->slug = Str::slug($title);

		return $this;
	}

	/**
	 * Définit le slug du modèle
	 *
	 * @param string $slug
	 *
	 * @return $this
	 */
	public function setSlug($slug) {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Ajoute un champ
	 *
	 * @param string $fieldName
	 * @param Field $field
	 *
	 * @return $this
	 *
	 * @throws Exception
	 */
	public function addField($fieldName, $field) {
		if (!in_array($fieldName, array_keys($this->fields)))
			$this->fields[$fieldName] = $field;
		else
			throw new Exception('Field "' . $fieldName .'" already exists in
				model "' . $this->getTitle() . '"');

		return $this;
	}

	/**
	 * Définir la vue
	 *
	 * @param string $viewFilename
	 *
	 * @return $this
	 */
	public function setViewFilename($viewFilename) {
		$this->viewFilename = $viewFilename;

		return $this;
	}

	/**
	 * Récupérer le titre
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Récupérer le slug
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Récupérer les champs
	 *
	 * @return Field[]
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Récupérer le chemin vers la vue
	 *
	 * @return string
	 */
	public function getViewFilename() {
		return $this->viewFilename;
	}
}
