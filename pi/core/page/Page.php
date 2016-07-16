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

namespace Pi\Core\Page;

use Pi\Lib\Str;

class Page implements \JsonSerializable {
	/** @var string Slug de la page */
	private $slug;

	/** @var string Titre de la page */
	private $title;

	/** @var string Modèle utilisé par la page */
	private $model;

	/** @var \DateTime Date de création de la page */
	private $createdAt;

	/** @var \DateTime Date de dernière mise à jour de la page */
	private $updatedAt;

	/** @var array Liste des champs de la page */
	private $fields;

	/**
	 * Constructeur
	 */
	public function __construct() {
		$this->slug = '';
		$this->title = '';
		$this->model = '';
		$this->createdAt = null;
		$this->updatedAt = null;
		$this->fields = [];
	}

	/**
	 * Définit le titre du modèle
	 *
	 * @param $title Titre de la page
	 * @param $overrideSlug Si true, change le slug associé à la page, sinon
	 *                      celui-ci reste inchangé (true par défaut)
	 *
	 * @return $this
	 */
	public function setTitle(string $title, bool $overrideSlug = true): Page {
		$this->title = $title;

		if ($overrideSlug)
			$this->slug = Str::slug($title);

		return $this;
	}

	/**
	 * Définir le modèle utilisé
	 *
	 * @param $model
	 *
	 * @return $this
	 */
	public function setModel(string $model): Page {
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
	public function setCreatedAt(\DateTime $createdAt): Page {
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
	public function setUpdatedAt(\DateTime $updatedAt): Page {
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
	public function setFields(array $fields): Page {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * Récupérer le slug
	 *
	 * @return string
	 */
	public function getSlug(): string {
		return $this->slug;
	}

	/**
	 * Récupérer le titre
	 *
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * Récupérer le modèle utilisé
	 *
	 * @return string
	 */
	public function getModel(): string {
		return $this->model;
	}

	/**
	 * Récupérer la date de création de la page
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}

	/**
	 * Récupérer la date de dernière mise à jour de la page
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt(): \DateTime {
		return $this->updatedAt;
	}

	/**
	 * Récupérer les champs
	 *
	 * @return array
	 */
	public function getFields(): array {
		return $this->fields;
	}

	/**
	 * Enregistrer la page dans un fichier
	 *
	 * @param $filename
	 *
	 * @return int
	 */
	public function saveToFile(string $filename): int {
		return file_put_contents($filename, $this->jsonSerialize());
	}

	/**
	 * Représentation JSON de la page
	 *
	 * @return Représentation JSON de la page
	 */
	public function jsonSerialize(): string {
		$arr = [];

		$arr['title'] = $this->getTitle();
		$arr['model'] = $this->getModel();
		$arr['created_at'] = $this->getCreatedAt()->format(\DateTime::ISO8601);
		$arr['updated_at'] = $this->getUpdatedAt()->format(\DateTime::ISO8601);
		$arr['fields'] = [];

		foreach ($this->getFields() as $fieldName => $field)
			$arr['fields'][$fieldName] = (string) $field;

		return json_encode($arr);
	}
}
