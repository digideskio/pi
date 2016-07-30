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

namespace Pi\Core\Repository;

interface IRepository {
	/**
	 * Récupérer tous les éléments
	 */
	public function findAll(): array;

	/**
	 * Récupérer un élément par son slug
	 */
	public function findBySlug(string $slug);

	/**
	 * Enregistrer l'élément
	 */
	public function save($element): bool;

	/**
	 * Supprimer l'élément
	 */
	public function remove($element): bool;
}
