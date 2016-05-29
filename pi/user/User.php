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

namespace Pi\User;

class User {
	/** @var string Pseudonyme */
	protected $username;

	/** @var string Mot de passe */
	protected $password;

	/** @var string Nom du rôle */
	protected $role;

	/** @var string[] Permissions accordées à l'utilisateur */
	protected $permissions;

	/**
	 * Constructeur de la classe
	 *
	 * @param array $data Données fournies pour contruire l'utilisateur
	 */
	public function __construct($data) {
		$this->username = $data['username'] ?? '';
		$this->password = $data['password'] ?? '';
		$this->role = $data['role'] ?? '';
		$this->permissions = $data['permissions'] ?? [];
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

	/**
	 * Ajouter une permission
	 *
	 * @param string $permission Permission à ajouter
	 *
	 * @return $this
	 */
	public function addPermission($permission) {
		$this->permissions[] = $permission;

		return $this;
	}

	/**
	 * Pseudonyme de l'utilisateur
	 *
	 * @param string $username
	 *
	 * @return $this
	 */
	public function setUsername($username) {
		$this->username = $username;

		return $this;
	}

	/**
	 * Mot de passe de l'utilisateur
	 *
	 * @param string $password
	 *
	 * @return $this
	 */
	public function setPassword($password) {
		$this->password = $password;

		return $this;
	}

	/**
	 * Role de l'utilisateur
	 *
	 * @param string $role
	 *
	 * @return $this
	 */
	public function setRole($role) {
		$this->role = $role;

		return $this;
	}

	/**
	 * Permissions de l'utilisateur
	 *
	 * @param string[] $permissions
	 *
	 * @return $this
	 */
	public function setPermissions($permissions) {
		$this->permissions = $permissions;

		return $this;
	}

	/**
	 * Pseudonyme de l'utilisateur
	 *
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * Mot de passe de l'utilisateur
	 *
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Role de l'utilisateur
	 *
	 * @return string
	 */
	public function getRole() {
		return $this->role;
	}

	/**
	 * Permissions de l'utilisateur
	 *
	 * @return string[]
	 */
	public function getPermissions() {
		return $this->permissions;
	}
}
