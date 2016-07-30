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

namespace Pi\Lib\Html;

class Tag {
	/** @var string[] */
	private static $inlineTags = [
		'br',
		'hr',
		'img',
		'input'
	];

	/** @var string */
	private $name;

	/** @var array */
	private $attrs;

	/** @var string */
	private $content;

	/**
	 * Constructeur
	 */
	public function __construct(string $name,
	                            array $attrs = [],
	                            string $content = '') {
		$this->name = $name;
		$this->attrs = $attrs;
		$this->content = $content;
	}

	/**
	 * Ajouter un attribut à la balise
	 */
	public function addAttr(string $key, $value = true) {
		$this->attrs[$key] = $value;
	}

	/**
	 * Ajouter plusieurs attributs à la balise
	 */
	public function addAttrs(array $attrs) {
		foreach ($attrs as $key => $value)
			$this->addAttr($key, $value);
	}

	/**
	 * Supprimer un attribut
	 */
	public function removeAttr(string $key): bool {
		if (isset($this->attrs[$key])) {
			unset($this->attrs[$key]);

			return true;
		}

		return false;
	}

	/**
	 * Supprimer plusieurs attributs
	 */
	public function removeAttrs(array $attrs) {
		foreach ($attrs as $key => $value)
			$this->removeAttr($key);
	}

	/**
	 * Définir le contenu
	 */
	public function setContent(string $content) {
		$this->content = $content;
	}

	/**
	 * Récupérer la balise au format HTML
	 */
	public function __toString(): string {
		$html = '<' . $this->name;

		foreach ($this->attrs as $key => $value)
			if (is_bool($value) && $value)
 				$html .= ' ' . $key;
			else
				$html .= ' ' . $key . '="' . $value . '"';

		if (in_array($this->name, static::$inlineTags))
			$html .= ' />';
		else
			$html .= '>' . $this->content . '</' . $this->name . '>';

		return $html;
	}
}
