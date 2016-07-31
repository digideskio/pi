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

class Page {
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
	 * Définir le titre du modèle
	 */
	public function setTitle(string $title, bool $overrideSlug = true): Page {
		$this->title = $title;

		if ($overrideSlug)
			$this->slug = Str::slug($title);

		return $this;
	}

	/**
	 * Définir le slug de la page
	 */
	public function setSlug(string $slug): Page {
		$this->slug = Str::slug($slug);

		return $this;
	}

	/**
	 * Définir le modèle utilisé
	 */
	public function setModel(string $model): Page {
		$this->model = $model;

		return $this;
	}

	/**
	 * Définir la date de création
	 */
	public function setCreatedAt(\DateTime $createdAt): Page {
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Définir la date de dernière mise à jour
	 */
	public function setUpdatedAt(\DateTime $updatedAt): Page {
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * Définir les champs
	 */
	public function setFields(array $fields): Page {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * Récupérer le slug
	 */
	public function getSlug(): string {
		return $this->slug;
	}

	/**
	 * Récupérer le titre
	 */
	public function getTitle(): string {
		return $this->title;
	}

	/**
	 * Récupérer le modèle utilisé
	 */
	public function getModel(): string {
		return $this->model;
	}

	/**
	 * Récupérer la date de création de la page
	 */
	public function getCreatedAt(): \DateTime {
		return $this->createdAt;
	}

	/**
	 * Récupérer la date de dernière mise à jour de la page
	 */
	public function getUpdatedAt(): \DateTime {
		return $this->updatedAt;
	}

	/**
	 * Récupérer les champs
	 */
	public function getFields(): array {
		return $this->fields;
	}
}
