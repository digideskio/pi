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

namespace Pi\Lib\Html;

class Tag {
	protected static $inlineTags = [
		'br',
		'hr',
		'img',
		'input'
	];

	protected $name;
	protected $attrs;
	protected $content;

	public function __construct($name, $attrs = [], $content = '') {
		$this->name    = $name;
		$this->attrs   = $attrs;
		$this->content = $content;
		}

	public function addAttr($key, $value = true) {
		$this->attrs[$key] = $value;
		}

	public function addAttrs($attrs) {
		foreach ($attrs as $key => $value)
		$this->addAttr($key, $value);
	}

	public function removeAttr($key) {
		if (isset($this->attrs[$key])) {
			unset($this->attrs[$key]);

			return true;
		}

		return false;
	}

	public function removeAttrs($attrs) {
		foreach ($attrs as $key => $value)
			$this->removeAttr($key);
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function __toString() {
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
