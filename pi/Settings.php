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

use Pi\User;
use Pi\Lib\Yaml;

class Settings {
	/// Paramètres enregistrés
	protected static $settings = [];

	/// Initilisation des paramètres
	public static function initializeSettings() {
		static::$settings = Yaml::read(PI_DIR_CONTENT . 'settings.yaml');
	}

	/// Récupérer un paramètre dans le tableau des paramètres
	/// Syntaxe de la variable $setting : « site.theme »
	public static function get($setting) {
		return static::getValue(static::$settings, $setting);
	}

	/// Récupérer la liste de tous les utilisateurs
	public static function getUsers() {
		$usersList = [];
		$users = static::getValue(static::$settings, 'users');

		foreach ($users as $user)
			$userList[] = new User($user);

		return $userList;
	}

	/// Récupérer un utilisateur par son pseudonyme
	public static function getUser($username) {
		$correctUser = null;
		$users = static::getUsers();

		foreach ($users as $user) {
			if ($user->username == $username) {
				$correctUser = $user;
				break;
			}
		}

		return $correctUser;
	}

	/// Récupérer les paramètres
	public static function getSettings() {
		return static::$settings;
	}

	/// Récupérer une configuration dans les paramètres avec la syntaxe
	/// « roles.editor »
	protected static function getValue($array, $setting) {
		$value = null;
		$parts = explode('.', $setting);

		foreach ($parts as $part) {
			if (is_null($value))
				$value = isset($array[$part]) ? $array[$part] : null;
			else
				$value = isset($value[$part]) ? $value[$part] : null;
		}

		return $value;
	}
}
