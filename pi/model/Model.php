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

use Pi\Model\Field\BaseField;
use Pi\Lib\Json;

class Model {
	/** @var string Nom du fichier */
	protected $filename;

	/** @var string Titre du modèle */
	protected $title;

	/** @var BaseField[] Champs du modèle */
	protected $fields;

	/** @var string Slug du modèle */
	protected $slug;

	/**
	 * @param string $filename
	 *
	 * @throws Exception
	 */
	public function __construct($filename) {
		$model = Json::read($filename);

		// Vérification de la lecture du fichier
		if (is_null($model))
			throw new Exception('Error when parsing model "' . $filename . '"');

		// Vérification de la présence des champs
		if (!isset($model['title']))
			throw new Exception('"title" field is missed in model');

		if (!isset($model['fields']))
			throw new Exception('"fields" field is missed in model');

		// Vérification des types
		if (!is_string($model['title']))
			throw new Exception('"title" field has to be a string');

		if (!is_array($model['fields']))
			throw new Exception('"fields" field has to be an array');

		/* Détermination du slug */
		// Découpage du nom du fichier : a/b/c/d.e => [a, b, c, d.e]
		$parts = explode('/', $filename);
		
		// Suppression du dernier élément : [a, b, c, d.e] => [a, b, c]
		array_pop($parts);
		
		// Récupération du dernier élément restant : [a, b, c] => c
		$slug = $parts[count($parts) - 1];

		$this->filename = $filename;
		$this->title = $model['title'];
		$this->fields = [];
		$this->slug = $slug;

		foreach ($model['fields'] as $name => $field) {
			$class = ucfirst($field['type']) . 'Field';
			$class = 'Pi\\Model\\Field\\' . $class;

			$field['name'] = $name;

			$this->fields[] = new $class($field);
		}
	}

	/**
	 * Récupérer le nom du fichier
	 *
	 * @return string
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * Récupérer le titre du modèle
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Récupérer les champs du modèle
	 *
	 * @return BaseField[]
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Récupérer le slug du modèle
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}
}
