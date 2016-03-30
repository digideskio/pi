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
	public $username;
	public $password;
	public $permissions;

	public function __construct($data) {
		$this->username = $data['username'];
		$this->password = $data['password'];
		$this->permissions = $data['permissions'];
	}

	public function hasPermission($permission) {
		return in_array($permission, $this->permissions);
	}
}
