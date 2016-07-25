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

class Role {
	/** @var string Nom du rôle */
	private $name;

	/** @var string[] Permissions du rôle */
	private $permissions;

	/**
	 * Créer le rôle à partir d'un tableau
	 *
	 * @param array $data Données fournies pour contruire le rôle
	 */
	public function __construct(array $data) {
		$this->setName($data['name']);
		$this->setPermissions($data['permissions']);
	}

	/**
	 * Le rôle dispose t-il de la permission $permission ?
	 *
	 * @param string $permission Permission à tester
	 *
	 * @return bool Retourne true si le rôle dipose de la permission
	 *              $permission, false sinon
	 */
	public function hasPermission(string $permission): bool {
		return in_array($permission, $this->permissions);
	}

	/**
	 * Ajouter une permission
	 *
	 * @param string $permission Permission à ajouter
	 *
	 * @return $this L'instance du rôle
	 */
	public function addPermission(string $permission): Role {
		$this->permissions[] = $permission;

		return $this;
	}

	/**
	 * Modifier le nom du rôle
	 *
	 * @param string $name Nouveau nom
	 *
	 * @return $this L'instance du rôle
	 */
	public function setName(string $name): Role {
		$this->name = $name;

		return $this;
	}

	/**
	 * Modifier les permissions du rôle
	 *
	 * @param string[] $permissions Nouvelles permissions
	 *
	 * @return $this L'instance du rôle
	 */
	public function setPermissions(array $permissions): Role {
		$this->permissions = $permissions;

		return $this;
	}

	/**
	 * Récupérer le nom du rôle
	 *
	 * @return string Nom du rôle
	 */
	public function getName(): string {
		return $this->name;
	}

	/**
	 * Récupérer les permissions de l'utilisateur
	 *
	 * @return string[] Permissions de l'utilisateur
	 */
	public function getPermissions(): array {
		return $this->permissions;
	}
}
