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

use Pi\Lib\Json;
use Pi\User\User;

class Settings {
	/** @var string Chemin vers le fichier des paramètres */
	protected static $filename = PI_DIR_CONTENT . 'settings.json';

	/** @var array Paramètres enregistrés */
	protected static $settings = [];

	/**
	 * Initilisation des paramètres
	 */
	public static function initializeSettings() {
		static::$settings = Json::read(static::$filename);
	}

	/**
	 * Enregistre les paramètres
	 *
	 * @return bool
	 */
	public static function save() {
		return Json::write(static::$filename, static::$settings);
	}

	/**
	 * Récupérer un paramètre dans le tableau des paramètres
	 * Syntaxe de la variable $setting : « site.theme »
	 *
	 * @param string $setting
	 * @param mixed $defaultValue
	 *
	 * @return mixed
	 */
	public static function get($setting, $defaultValue = null) {
		$value = static::getValue(static::$settings, $setting);

		if (is_null($value))
			return $defaultValue;
		else
			return $value;
	}

	/**
	 * Récupérer la liste de tous les utilisateurs
	 *
	 * @return User[]
	 */
	public static function getUsers() {
		$userList = [];
		$users = static::getValue(static::$settings, 'users');

		foreach ($users as $username => $data) {
			$data['username'] = $username;

			$userList[] = new User($data);
		}

		return $userList;
	}

	/**
	 * Récupérer un utilisateur par son pseudonyme
	 *
	 * @param $username
	 *
	 * @return User|null
	 */
	public static function getUser($username) {
		$correctUser = null;
		$users = static::getUsers();

		foreach ($users as $user) {
			if ($user->getUsername() == $username) {
				$correctUser = $user;
				break;
			}
		}

		return $correctUser;
	}

	/**
	 * Récupérer les paramètres
	 *
	 * @return array
	 */
	public static function getSettings() {
		return static::$settings;
	}

	/**
	 * Récupérer une configuration dans les paramètres avec la syntaxe
	 * « roles.editor »
	 *
	 * @param array $array
	 * @param string $setting
	 *
	 * @return mixed
	 */
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
