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

namespace Pi\Page;

use DateTime;
use Pi\Lib\Json;

class Page {
	/** @var string Titre de la page */
	protected $title;

	/** @var string Modèle utilisé par la page */
	protected $model;

	/** @var DateTime Date de création de la page */
	protected $createdAt;

	/** @var DateTime Date de dernière mise à jour de la page */
	protected $updatedAt;

	/** @var array Liste des champs de la page */
	protected $fields;

	public static function getLastVersion() {
		$page = new static();

		$page->setTitle('ok');
		$page->setModel('page');

		return $page;
	}

	/**
	 * Constructeur
	 */
	public function __construct() {
		$this->title = '';
		$this->model = '';
		$this->createdAt = new DateTime();
		$this->updatedAt = new DateTime();
		$this->fields = [];
	}

	/**
	 * Définir le titre
	 *
	 * @param $title
	 *
	 * @return $this
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Définir le modèle utilisé
	 *
	 * @param $model
	 *
	 * @return $this
	 */
	public function setModel($model) {
		$this->model = $model;

		return $this;
	}

	/**
	 * Définir la date de création
	 *
	 * @param $createdAt
	 *
	 * @return $this
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Définir la date de dernière mise à jour
	 *
	 * @param $updatedAt
	 *
	 * @return $this
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * Définir les champs
	 *
	 * @param $fields
	 *
	 * @return $this
	 */
	public function setFields($fields) {
		$this->fields = $fields;

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
	 * Récupérer le modèle utilisé
	 *
	 * @return string
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * Récupérer la date de création de la page
	 *
	 * @return DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * Récupérer la date de dernière mise à jour de la page
	 *
	 * @return DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * Récupérer les champs
	 *
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Enregistrer la page dans un fichier
	 *
	 * @param $filename
	 *
	 * @return int
	 */
	public function saveToFile($filename) {
		return file_put_contents($filename, (string) $this);
	}

	/**
	 * Représentation JSON de la page
	 *
	 * @return string
	 */
	public function __toString() {
		$arr = [];

		$arr['title'] = $this->getTitle();
		$arr['model'] = $this->getModel();
		$arr['created_at'] = $this->getCreatedAt()->format(DateTime::ISO8601);
		$arr['updated_at'] = $this->getUpdatedAt()->format(DateTime::ISO8601);
		$arr['fields'] = [];

		foreach ($this->getFields() as $field)
			$arr['fields'] = (string) $field;

		return Json::encode($arr);
	}
}
