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
	/** @var string */
	public $username;

	/** @var string */
	public $password;

	/** @var string */
	public $role;

	/** @var string[] */
	public $permissions;

	/**
	 * @param $data
	 */
	public function __construct($data) {
		$this->username = $data['username'];
		$this->password = $data['password'];
		$this->role = $data['role'];

		// Récupération des permissions à partir du nom du role
		$this->permissions = Settings::get('roles.' . $this->role . '.permissions');
	}

	/**
	 * @param $permission
	 *
	 * @return bool
	 */
	public function hasPermission($permission) {
		return in_array($permission, $this->permissions);
	}
}
