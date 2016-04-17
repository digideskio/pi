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

use Pi\Model\Field\BaseField;
use Pi\Lib\Json;

class Model {
	/** @var string */
	protected $file;

	/** @var string */
	protected $title;

	/** @var BaseField[] */
	protected $fields;

	/** @var string */
	protected $slug;

	/**
	 * @param string $file
	 */
	public function __construct($file) {
		$model = Json::read($file);

		/* Détermination du slug */
		// Découpage du nom du fichier : a/b/c/d.e => [a, b, c, d.e]
		$parts = explode('/', $file);
		
		// Suppression du dernier élément : [a, b, c, d.e] => [a, b, c]
		array_pop($parts);
		
		// Récupération du dernier élément restant : [a, b, c] => c
		$slug = $parts[count($parts) - 1];

		$this->file = $file;
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
	 * @return string
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return BaseField[]
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}
}
