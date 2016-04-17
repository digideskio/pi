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

namespace Pi;

class User {
	/** @var string Pseudonyme */
	public $username;

	/** @var string Mot de passe */
	public $password;

	/** @var string Nom du rôle */
	public $role;

	/** @var string[] Permissions accordées à l'utilisateur */
	public $permissions;

	/**
	 * Constructeur de la classe
	 *
	 * @param array $data Données fournies pour contruire l'utilisateur
	 */
	public function __construct($data) {
		$this->username = $data['username'];
		$this->password = $data['password'];
		$this->role = $data['role'];

		// Récupération des permissions à partir du nom du role
		$this->permissions = Settings::get(
			'roles.' . $this->role . '.permissions');
	}

	/**
	 * L'utilisateur dispose t-il de cette permission ?
	 *
	 * @param string $permission
	 *
	 * @return bool Retourne true si l'utilisateur dipose de la permission
	 *              $permission, false sinon
	 */
	public function hasPermission($permission) {
		return in_array($permission, $this->permissions);
	}
}
