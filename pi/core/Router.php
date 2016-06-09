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

class Router {
	/** @var string Chemin */
	private $path;

	/** @var string[] Requête complémentaire */
	private $query;

	/**
	 * Initialise le chemin courant
	 */
	public function __construct() {
		// Chemin par défaut
		$this->path = 'home';
		$this->query = '';

		if (isset($_SERVER['PATH_INFO'])) {
			preg_match('/\/?([a-zA-Z0-9\/_-]*)\/?&?(.*)/', $_SERVER['PATH_INFO'], $matches);

			$parts = explode('&', $matches[2]);
			$query = [];

			foreach ($parts as $part)
				$query[] = explode('=', $part, 2);

			$this->path = trim($matches[1], '/');
			$this->query = $query;
		}

		// Si le chemin est vide, le chemin par défaut est préféré
		if (empty($this->path))
			$this->path = 'home';
	}

	/**
	 * Récupérer le chemin
	 *
	 * @return Le chemin vers la page
	 */
	public function getPath(): string {
		return $this->path;
	}

	/**
	 * Récupérer la requête complémentaire
	 *
	 * @return string[]
	 */
	public function getQuery(): array {
		return $this->query;
	}
}
