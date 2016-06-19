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

use Pi\Lib\Str;

class Model {
	/** @var string Nom du modèle */
	private $title;

	/** @var string Slug du modèle */
	private $slug;

	/** @var Field[] Champs du modèle */
	private $fields;

	/** @var string Vue du modèle */
	private $viewFilename;

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
	 * Constructeur du modèle
	 *
	 * @param $title Titre du modèle
	 */
	public function __construct(string $title = '') {
		$this->setTitle($title);

		$this->fields = [];
		$this->viewFilename = '';
	}

	/**
	 * Définit le titre du modèle
	 *
	 * @param $title Titre du modèle
	 * @param $overrideSlug Si true, change le slug associé au modèle, sinon,
	 *                      celui-ci reste inchangé (true par défaut)
	 *
	 * @return $this
	 */
	public function setTitle(string $title, bool $overrideSlug = true): Model {
		$this->title = $title;

		if ($overrideSlug)
			$this->slug = Str::slug($title);

		return $this;
	}

	/**
	 * Définit le slug du modèle
	 *
	 * @param $slug
	 *
	 * @return $this
	 */
	public function setSlug(string $slug): Model {
		$this->slug = Str::slug($slug);

		return $this;
	}

	/**
	 * Ajoute un champ
	 *
	 * @param $fieldName
	 * @param $field
	 *
	 * @return $this
	 *
	 * @throws \Exception
	 */
	public function addField(string $fieldName, Field $field): Model {
		if (!in_array($fieldName, array_keys($this->fields)))
			$this->fields[$fieldName] = $field;
		else
			throw new \Exception('Field "' . $fieldName .'" already exists in
				model "' . $this->getTitle() . '"');

		return $this;
	}

	/**
	 * Définir la vue
	 *
	 * @param $viewFilename
	 *
	 * @return $this
	 */
	public function setViewFilename(string $viewFilename): Model {
		$this->viewFilename = $viewFilename;

		return $this;
	}

	/**
	 * Récupérer le titre
	 *
	 * @return Titre du modèle
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * Récupérer le slug
	 *
	 * @return Slug du modèle
	 */
	public function getSlug(): string {
		return $this->slug;
	}

	/**
	 * Récupérer les champs
	 *
	 * @return Field[] Champs du modèles
	 */
	public function getFields(): array {
		return $this->fields;
	}

	/**
	 * Récupérer le chemin vers la vue
	 *
	 * @return Chemin vers la vue du modèle
	 */
	public function getViewFilename(): string {
		return $this->viewFilename;
	}
}
