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

namespace Pi\Core;

use Pi\Lib\Json;

class Model {
	public $file;
	public $title;
	public $fields;
	public $slug;

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
			$class = 'Pi\\Core\\Field\\' . $class;

			$field['name'] = $name;

			$this->fields[] = new $class($field);
		}
	}
}
