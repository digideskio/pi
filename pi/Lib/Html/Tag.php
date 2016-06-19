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
	protected static $inlineTags = [
		'br',
		'hr',
		'img',
		'input'
	];

	/** @var string */
	protected $name;

	/** @var array */
	protected $attrs;

	/** @var string */
	protected $content;

	/**
	 * @param $name
	 * @param $attrs
	 * @param $content
	 */
	public function __construct(string $name,
	                            array $attrs = [],
	                            string $content = '') {
		$this->name = $name;
		$this->attrs = $attrs;
		$this->content = $content;
	}

	/**
	 * @param $key
	 * @param mixed $value
	 */
	public function addAttr(string $key, $value = true) {
		$this->attrs[$key] = $value;
	}

	/**
	 * @param $attrs
	 */
	public function addAttrs(array $attrs) {
		foreach ($attrs as $key => $value)
			$this->addAttr($key, $value);
	}

	/**
	 * @param $key
	 *
	 * @return true si l'attribut a été supprimé, false sinon
	 */
	public function removeAttr(string $key): bool {
		if (isset($this->attrs[$key])) {
			unset($this->attrs[$key]);

			return true;
		}

		return false;
	}

	/**
	 * @param $attrs
	 */
	public function removeAttrs(array $attrs) {
		foreach ($attrs as $key => $value)
			$this->removeAttr($key);
	}

	/**
	 * @param $content
	 */
	public function setContent(string $content) {
		$this->content = $content;
	}

	/**
	 * @return La balise au format HTML
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
