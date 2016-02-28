<?php

namespace Pi\Core;

use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
use Twig_Extension_StringLoader;

use Pi\Lib\Markdown;

class Renderer {
	private $loader;
	private $twig;

	public function __construct($theme) {
		// Définition du dossier des modèles de page
		$this->loader = new Twig_Loader_Filesystem('./content/themes/' . $theme . '/tpl');
		$this->loader->addPath('./content/models');
		$this->loader->addPath('./pi/views');

		$this->twig = new Twig_Environment($this->loader);

		// Filtre markdown : « {{ ma_variable|markdown }} »
		// Formate le contenu markdown en HTML
		$this->twig->addFilter(new Twig_SimpleFilter('markdown', function($text) {
			return Markdown::html($text);
		}, [ 'is_safe' => [ 'html' ] ]));

		// Fonction « getAllPages »
		$this->twig->addFunction(new Twig_SimpleFunction('getAllPages', function() {
			$dirs = scandir('content/pages');

			$dirs = array_filter($dirs, function($dir) {
				return ($dir != '.' && $dir != '..');
			});

			return $dirs;
		}));

		// Fonction « template_from_string » : « {{ include(template_from_string("chaine")) }} »
		// Interprète avec Twig le contenu de la chaine
		$this->twig->addExtension(new Twig_Extension_StringLoader());
	}

	public function render($file, $variables) {
		return $this->twig->render($file, $variables);
	}
}
