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

use Pi\Lib\Json;

class Settings {
	/** @var array Paramètres enregistrés */
	protected static $settings = [];

	/**
	 * Initilisation des paramètres
	 */
	public static function initializeSettings() {
		static::$settings = Json::read(PI_DIR_CONTENT . 'settings.json');
	}

	/**
	 * Récupérer un paramètre dans le tableau des paramètres
	 * Syntaxe de la variable $setting : « site.theme »
	 *
	 * @param string $setting
	 *
	 * @return null
	 */
	public static function get($setting) {
		return static::getValue(static::$settings, $setting);
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
			if ($user->username == $username) {
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
