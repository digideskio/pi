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

use Pi\Core\App;
use Pi\Model\Field\BaseField;
use Pi\Lib\Json;

class Model {
	/** @var string Nom du fichier du modèle */
	protected $modelFilename;

	/** @var string Nom du fichier de la vue */
	protected $viewFilename;

	/** @var string Titre du modèle */
	protected $title;

	/** @var BaseField[] Champs du modèle */
	protected $fields;

	/** @var string Slug du modèle */
	protected $slug;

	/**
	 * Récupérer la liste des modèles
	 *
	 * @return Model[]
	 */
	public static function getAll() {
		$models = [];

		foreach (scandir(PI_DIR_MODELS) as $dir) {
			if ($dir == '.' || $dir == '..')
				continue;

			$models[] = new Model($dir);
		}

		return $models;
	}

	/**
	 * Construit un modèle à partir de son nom
	 *
	 * @param string $modelName Nom du modèle
	 * @param string $modelFilename
	 * @param string $viewFilename
	 *
	 * @throws Exception
	 */
	public function __construct($modelName, $modelFilename = null,
	                            $viewFilename = null) {
		$modelFilename = $modelFilename ??
			PI_DIR_MODELS . $modelName . '/model.json';

		$viewFilename = $viewFilename ??
			PI_DIR_MODELS . $modelName . '/view.html';

		$this->modelFilename = $modelFilename;
		$this->viewFilename = $viewFilename;

		$model = Json::read($this->modelFilename);

		// Vérification de la lecture du fichier
		if (is_null($model))
			throw new Exception('Error when parsing model "' . $modelName
				. '"');

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

		$this->title = $model['title'];
		$this->fields = [];
		$this->slug = $modelName;

		foreach ($model['fields'] as $name => $field) {
			$fieldClass = App::getField($field['type']);

			$this->fields[] = new $fieldClass($field);
		}
	}

	/**
	 * Récupérer le nom du fichier
	 *
	 * @return string
	 */
	public function getModelFilename() {
		return $this->modelFilename;
	}

	/**
	 * Récupérer le nom du fichier
	 *
	 * @return string
	 */
	public function getViewFilename() {
		return $this->viewFilename;
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
