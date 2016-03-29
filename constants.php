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

const DS = DIRECTORY_SEPARATOR;
const EOL = PHP_EOL;

define('PI_DIR_SITE', dirname(__FILE__) . DS);
define('PI_DIR_CONTENT', PI_DIR_SITE . 'content' . DS);
define('PI_DIR_MODELS', PI_DIR_CONTENT . 'models' . DS);
define('PI_DIR_PAGES', PI_DIR_CONTENT . 'pages' . DS);
define('PI_DIR_THEMES', PI_DIR_CONTENT . 'themes' . DS);

define('PI_URL_SITE', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/');
define('PI_URL_CONTENT', PI_URL_SITE . 'content/');
define('PI_URL_MODELS', PI_URL_CONTENT . 'models/');
define('PI_URL_PAGES', PI_URL_CONTENT . 'pages/');
define('PI_URL_THEMES', PI_URL_CONTENT . 'themes/');
