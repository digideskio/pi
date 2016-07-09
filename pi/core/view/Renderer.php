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

namespace Pi\Core\View;

use Pi\Core\App\App;
use Pi\Lib\Twig;
use Pi\Lib\Markdown;

class Renderer {
	/** @var Twig\Loader\Filesystem */
	private $loader;

	/** @var Twig\Environment */
	private $twig;

	/** @var Pi */
	private $app;

	/**
	 * Constructeur
	 *
	 * @param $app Application
	 */
	public function __construct(App $app) {
		// Application
		$this->app = $app;

		// Définition du dossier des modèles de page
		$this->loader = new Twig\Loader\Filesystem($app->getRoot());
		$this->twig = new Twig\Environment($this->loader);

		// Filtre markdown : « {{ ma_variable|markdown }} »
		// Formate le contenu markdown en HTML
		$this->twig->addFilter(new Twig\SimpleFilter('markdown', function($text) {
			return Markdown::html($text);
		}, [ 'is_safe' => [ 'html' ] ]));

		// Détermine si le slug fournit est la page actuellement ouverte
		// à faire : éviter de déterminer le chemin courant ici alors qu'il est
		//           déterminé aussi dans la classe App
		$this->twig->addFunction(new Twig\SimpleFunction('is_current_page', function($slug) {
			$currentPath = 'home';

			if (isset($_SERVER['PATH_INFO']))
				$currentPath = trim($_SERVER['PATH_INFO'], '/');

			return $slug == $currentPath;
		}));

		// Fonction « template_from_string » :
		//   « {{ include(template_from_string("chaine")) }} »
		// Interprète avec Twig le contenu de la chaine
		$this->twig->addExtension(new Twig\Extension\StringLoader());
	}

	/**
	 * Ajout un chemin vers des vues
	 *
	 * @param $path Chemin vers le dossier
	 * @param $namespace Espace de noms
	 *
	 * @throws Twig\Error\Loader
	 */
	public function addPath(string $path, string $namespace = null) {
		$this->loader->addPath($path, $namespace);
	}

	/**
	 * @param $file
	 * @param $variables
	 *
	 * @return Le rendu
	 */
	public function render(string $file, array $variables): string {
		$variables = array_merge($this->app->getVariables(), $variables);

		return $this->twig->render($file, $variables);
	}
}
