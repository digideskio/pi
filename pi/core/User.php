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

class User {
	/** @var string Pseudonyme */
	private $username;

	/** @var string Mot de passe */
	private $password;

	/** @var string Nom du rôle */
	private $role;

	/** @var string[] Permissions accordées à l'utilisateur */
	private $permissions;

	/**
	 * Constructeur de la classe
	 *
	 * @param $data Données fournies pour contruire l'utilisateur
	 */
	public function __construct(array $data) {
		$this->username = $data['username'] ?? '';
		$this->password = $data['password'] ?? '';
		$this->role = $data['role'] ?? '';
		$this->permissions = $data['permissions'] ?? [];
	}

	/**
	 * L'utilisateur dispose t-il de cette permission ?
	 *
	 * @param $permission Permission à tester
	 *
	 * @return Retourne true si l'utilisateur dipose de la permission
	 *         $permission, false sinon
	 */
	public function hasPermission(string $permission): bool {
		return in_array($permission, $this->permissions);
	}

	/**
	 * Ajouter une permission
	 *
	 * @param $permission Permission à ajouter
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function addPermission(string $permission): User {
		$this->permissions[] = $permission;

		return $this;
	}

	/**
	 * Pseudonyme de l'utilisateur
	 *
	 * @param $username
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setUsername(string $username): User {
		$this->username = $username;

		return $this;
	}

	/**
	 * Mot de passe de l'utilisateur
	 *
	 * @param $password
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setPassword(string $password): User {
		$this->password = $password;

		return $this;
	}

	/**
	 * Role de l'utilisateur
	 *
	 * @param $role
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setRole(string $role): User {
		$this->role = $role;

		return $this;
	}

	/**
	 * Permissions de l'utilisateur
	 *
	 * @param string[] $permissions
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setPermissions(array $permissions): User {
		$this->permissions = $permissions;

		return $this;
	}

	/**
	 * Pseudonyme de l'utilisateur
	 *
	 * @return Pseudonyme de l'utilisateur
	 */
	public function getUsername(): string {
		return $this->username;
	}

	/**
	 * Mot de passe de l'utilisateur
	 *
	 * @return Mot de passe de l'utilisateur
	 */
	public function getPassword(): string {
		return $this->password;
	}

	/**
	 * Rôle de l'utilisateur
	 *
	 * @return Rôle de l'utilisateur
	 */
	public function getRole(): string {
		return $this->role;
	}

	/**
	 * Permissions de l'utilisateur
	 *
	 * @return string[] Permissions de l'utilisateur
	 */
	public function getPermissions(): array {
		return $this->permissions;
	}
}
