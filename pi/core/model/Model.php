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

use Pi\Core\App\App;
use Pi\Core\App\Pi;
use Pi\Core\Page\Page;
use Pi\Lib\Str;

class Model {
	/** @var Pi Application */
	private $app;

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
	 */
	public static function fromArray($array): Model {
		$model = new Model($array['title']);

		foreach ($array['fields'] as $name => $field) {
			// @todo Corriger cet appel
			$fieldClass = App::getField($field['type']);

			$field['name'] = $name;

			$model->addField($name, $fieldClass::fromArray($field));
		}

		return $model;
	}

	/**
	 * Constructeur du modèle
	 */
	public function __construct(Pi $app, string $title = '') {
		$this->app = $app;

		$this->setTitle($title);

		$this->fields = [];
		$this->viewFilename = '';
	}

	/**
	 * Complète les valeurs des champs
	 */
	public function fillFieldsWithPage(Page $page) {
		foreach ($page->getFields() as $name => $value)
			$this->fields[$name]->setValue($value);
	}

	/**
	 * Définit le titre du modèle
	 */
	public function setTitle(string $title, bool $overrideSlug = true): Model {
		$this->title = $title;

		if ($overrideSlug)
			$this->slug = Str::slug($title);

		return $this;
	}

	/**
	 * Définit le slug du modèle
	 */
	public function setSlug(string $slug): Model {
		$this->slug = Str::slug($slug);

		return $this;
	}

	/**
	 * Ajoute un champ
	 */
	public function addField(string $fieldName, Field $field): Model {
		if (!in_array($fieldName, array_keys($this->fields))) {
			$field->setName($fieldName);

			$this->fields[$fieldName] = $field;
		} else {
			throw new \Exception('Field "' . $fieldName . '" already exists in
				model "' . $this->getTitle() . '"');
		}

		return $this;
	}

	/**
	 * @todo Supprimer la dépendance dangereuse envers une constante
	 *
	 * Définir la vue
	 */
	public function setViewFilename(string $viewFilename): Model {
		// Supprime le chemin racine
		// Exemple : /var/www/truc/content/modules/exemple/test.html
		//   devient content/modules/exemple/test.html
		$this->viewFilename = substr($viewFilename, strlen(PI_DIR_SITE));

		return $this;
	}

	/**
	 * Récupérer le titre
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * Récupérer le slug
	 */
	public function getSlug(): string {
		return $this->slug;
	}

	/**
	 * Récupérer les champs
	 */
	public function getFields(): array {
		return $this->fields;
	}

	/**
	 * Récupérer le chemin vers la vue
	 */
	public function getViewFilename(): string {
		return $this->viewFilename;
	}

	/**
	 * @todo
	 *
	 * Créer un nouveau champ
	 */
	protected function newField(string $fieldName): Field {
		return $this->app->getField($fieldName);
		//return $this->app->newField($fieldName);
	}
}
