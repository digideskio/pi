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

class UserRepository implements IRepository {
	/**
	 * Récupérer tous les éléments
	 *
	 * @return array Liste de tous les éléments
	 */
	public function findAll(): array {
		return [];
	}

	/**
	 * @param string $slug
	 *
	 * @return mixed
	 */
	public function findBySlug(string $slug) {
		return null;
	}

	/**
	 * @param $user
	 *
	 * @return bool Succès
	 */
	public function save($user): bool {
		return false;
	}

	/**
	 * @param $user
	 *
	 * @return bool Succès
	 */
	public function remove($user): bool {
		return false;
	}
}
