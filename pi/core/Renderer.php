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

use Twig_Environment;
use Twig_Extension_StringLoader;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

use Pi\Lib\Markdown;

class Renderer {
	/** @var Twig_Loader_Filesystem */
	private $loader;

	/** @var Twig_Environment */
	private $twig;

	/** @var App */
	private $app;

	/**
	 * Constructeur
	 *
	 * @param App $app
	 */
	public function __construct($app) {
		// Application
		$this->app = $app;

		// Définition du dossier des modèles de page
		$this->loader = new Twig_Loader_Filesystem('/');
		$this->twig = new Twig_Environment($this->loader);

		// Filtre markdown : « {{ ma_variable|markdown }} »
		// Formate le contenu markdown en HTML
		$this->twig->addFilter(new Twig_SimpleFilter('markdown', function($text) {
			return Markdown::html($text);
		}, [ 'is_safe' => [ 'html' ] ]));

		// Détermine si le slug fournit est la page actuellement ouverte
		// à faire : éviter de déterminer le chemin courant ici alors qu'il est
		//           déterminé aussi dans la classe App
		$this->twig->addFunction(new Twig_SimpleFunction('is_current_page', function($slug) {
			$currentPath = 'home';

			if (isset($_SERVER['PATH_INFO']))
				$currentPath = trim($_SERVER['PATH_INFO'], '/');

			return $slug == $currentPath;
		}));

		// Fonction « template_from_string » : « {{ include(template_from_string("chaine")) }} »
		// Interprète avec Twig le contenu de la chaine
		$this->twig->addExtension(new Twig_Extension_StringLoader());
	}

	/**
	 * Ajout un chemin vers des vues
	 *
	 * @param string $path Chemin vers le dossier
	 * @param string $namespace Espace de noms
	 *
	 * @throws \Twig_Error_Loader
	 */
	public function addPath($path, $namespace = null) {
		$this->loader->addPath($path, $namespace);
	}

	/**
	 * @param string $file
	 * @param array $variables
	 *
	 * @return string
	 */
	public function render($file, $variables) {
		$variables = array_merge($this->getVariables(), $variables);

		return $this->twig->render($file, $variables);
	}

	/**
	 * Variables globales qui seront envoyées à toutes les vues
	 *
	 * @return array
	 */
	public function getVariables() {
		return [
			'settings' => $this->app->getSettings(),

			'url' => [
				'site' => PI_URL_SITE,
				'content' => PI_URL_CONTENT,
				'pages' => PI_URL_PAGES,
				'themes' => PI_URL_THEMES,
				'theme' => PI_URL_THEME,
				'curent' => $this->app->getPath()
			],

			'dir' => [
				'site' => PI_DIR_SITE,
				'content' => PI_DIR_CONTENT,
				'pages' => PI_DIR_PAGES,
				'themes' => PI_DIR_THEMES,
				'theme' => PI_DIR_THEME
			],

			'jsUrls' => $this->app->getJsUrls(),
			'cssUrls' => $this->app->getCssUrls(),

			'pages' => $this->app->getPages(),
			'users' => $this->app->getUsers()
		];
	}
}
