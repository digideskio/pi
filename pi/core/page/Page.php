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

use Pi\Lib\Json;

class Page implements \JsonSerializable {
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
	 * Créer une instance de Page à partir d'un fichier JSON
	 *
	 * @param $filename Fichier JSON
	 *
	 * @return Page
	 *
	 * @throws \Exception
	 */
	public static function fromFile(string $filename): Page {
		if (!file_exists($filename))
			throw new \Exception('File "' . $filename . '" does not exists.');

		$json = Json::read($filename);

		$createdAt = new \DateTime();
		$createdAt->setTimestamp($json->created_at);

		$updatedAt = new \DateTime();
		$updatedAt->setTimestamp($json->updated_at);

		$page = new static();

		$page->setTitle($json->title);
		$page->setModel($json->model);
		$page->setCreatedAt($createdAt);
		$page->setUpdatedAt($updatedAt);
		$page->setFields((array) $json->fields);

		return $page;
	}

	/**
	 * @todo
	 *
	 * Récupérer la dernière version de la page
	 *
	 * @throws \Exception
	 */
	public static function getLastVersion($slug): Page {
		$versions = [];

		foreach (glob(PI_DIR_PAGES . $slug . '/*') as $pathfile) {
			$filename = basename($pathfile);

			$version = explode('.', $filename)[0];
			$versions[] = (int) $version;
		}

		if (empty($versions))
			throw new \Exception('Page "' . $slug . '" does not exists');

		$lastVersion = max($versions);

		$page = static::fromFile(PI_DIR_PAGES . $slug . '/'
			. $lastVersion . '.json');

		return $page;
	}

	/**
	 * Constructeur
	 */
	public function __construct() {
		$this->title = '';
		$this->model = '';
		$this->createdAt = null;
		$this->updatedAt = null;
		$this->fields = [];
	}

	/**
	 * Définir le titre
	 *
	 * @param $title
	 *
	 * @return $this
	 */
	public function setTitle(string $title): Page {
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
		return file_put_contents($filename, (string) $this);
	}

	/**
	 * Représentation JSON de la page
	 *
	 * @return Tableau PHP représentant la page et pouvant être encodé en JSON
	 */
	public function jsonSerialize(): array {
		$arr = [];

		$arr['title'] = $this->getTitle();
		$arr['model'] = $this->getModel();
		$arr['created_at'] = $this->getCreatedAt()->format(\DateTime::ISO8601);
		$arr['updated_at'] = $this->getUpdatedAt()->format(\DateTime::ISO8601);
		$arr['fields'] = [];

		foreach ($this->getFields() as $fieldName => $field)
			$arr['fields'][$fieldName] = (string) $field;

		return $arr;
	}
}
