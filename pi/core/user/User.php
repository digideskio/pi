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

namespace Pi\Core\User;

class User {
	/** @var string Pseudonyme */
	private $username;

	/** @var string Mot de passe */
	private $password;

	/** @var Role Rôle */
	private $role;

	/**
	 * Créer l'utilisateur à partir d'un tableau
	 *
	 * @param array $data Données fournies pour contruire l'utilisateur
	 */
	public function __construct(array $data) {
		$this->setUsername($data['username']);
		$this->setPassword($data['password']);
		$this->setRole($data['role']);
	}

	/**
	 * L'utilisateur dispose t-il de la permission $permission ?
	 *
	 * @param string $permission Permission à tester
	 *
	 * @return bool Retourne true si l'utilisateur dipose de la permission
	 *              $permission, false sinon
	 */
	public function hasPermission(string $permission): bool {
		return $this->role->hasPermission($permission);
	}

	/**
	 * Modifier le pseudonyme de l'utilisateur
	 *
	 * @param string $username Nouveau pseudonyme
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setUsername(string $username): User {
		$this->username = $username;

		return $this;
	}

	/**
	 * Modifier le mot de passe de l'utilisateur
	 *
	 * @param string $password Nouveau mot de passe
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setPassword(string $password): User {
		$this->password = $password;

		return $this;
	}

	/**
	 * Modifier le rôle de l'utilisateur
	 *
	 * @param Role $role Nouveau rôle
	 *
	 * @return $this L'instance de l'utilisateur.
	 */
	public function setRole(Role $role): User {
		$this->role = $role;

		return $this;
	}

	/**
	 * Récupérer le pseudonyme de l'utilisateur
	 *
	 * @return string Pseudonyme de l'utilisateur
	 */
	public function getUsername(): string {
		return $this->username;
	}

	/**
	 * Récupérer le mot de passe de l'utilisateur
	 *
	 * @return string Mot de passe de l'utilisateur
	 */
	public function getPassword(): string {
		return $this->password;
	}

	/**
	 * Récupérer le rôle de l'utilisateur
	 *
	 * @return string Rôle de l'utilisateur
	 */
	public function getRole(): string {
		return $this->role;
	}

	/**
	 * Récupérer les permissions de l'utilisateur
	 *
	 * @return string[] Permissions de l'utilisateur
	 */
	public function getPermissions(): array {
		return $this->role->getPermissions();
	}
}
