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

/*

Usage:

	$router = new Router();
	$router->get('route.primary', '/');
	$router->get('an.other', 'my_route/{d}');
	$router->get('an.other.route', 'an_other/route/{d}');

	$myRoute = $router->find('an_other/route/5');

	if ($myRoute)
		var_dump($myRoute);
	else
		var_dump('Route? I don\'t understand...');

*/

namespace Pi\Lib;

class Router {
	/** @var array */
	protected $routes;

	/** @var array */
	protected static $shortcuts = [
		'{char}'   => '([a-zA-Z_])',      // character
		'{digit}'  => '([0-9])',          // digit
		'{string}' => '([a-zA-Z_]+)',     // string
		'{number}' => '([0-9]+)',         // number
		'{slug}'   => '([a-zA-Z0-9_-]+)', // alphanumeric
		'{*}'      => '(.+)'              // all
	];

	/**
	 */
	public function __construct() {
		$this->routes = [];
	}

	/**
	 * @param $name
	 * @param $path
	 * @param $func
	 * @param string $method
	 *
	 * @return $this
	 */
	public function route($name, $path, $func, $method = 'GET') {
		$method = is_array($method) ? $method : [ $method ];

		$this->routes[$name] = [
			'path' => $path,
			'func' => $func,
			'method' => $method
		];

		return $this;
	}

	/**
	 * @param $name
	 * @param $path
	 * @param $func
	 *
	 * @return Router
	 */
	public function get($name, $path, $func) {
		return $this->route($name, $path, $func, 'GET');
	}

	/**
	 * @param $name
	 * @param $path
	 * @param $func
	 *
	 * @return Router
	 */
	public function post($name, $path, $func) {
		return $this->route($name, $path, $func, 'POST');
	}

	/**
	 * @param $tryPath
	 *
	 * @return $this
	 */
	public function find($tryPath) {
		$method = 'GET';
		$found = false;

		if (isset($_SERVER['REQUEST_METHOD']))
			$method = $_SERVER['REQUEST_METHOD'];

		$matches = [];

		foreach ($this->routes as $k => $v) {
			$path = strtr($v['path'], self::$shortcuts);

			if (
				preg_match('#^/?' . $path . '/?$#U', $tryPath, $matches)
				&&
				in_array($method, $v['method'])
			) {
				array_splice($matches, 0, 1);

				$matches = array_map(function($match) {
					return trim($match, '/');
				}, $matches);

				array_unshift($matches, $this);

				call_user_func_array($v['callback'], $matches);

				$found = false;
				break;
			}
		}

		if (!$found)
			exit;

		return $this;
	}
}
