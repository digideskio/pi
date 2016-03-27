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

namespace Pi\Core\Field;

abstract class BaseField {
	protected static $num = 0;

	public $id;
	public $name;
	public $label;
	public $default;
	public $required;
	public $message;
	public $width;
	public $placeholder;
	public $options;
	public $min;
	public $max;
	public $step;
	public $format;

	public function __construct($data) {
		$this->id = ++self::$num;

		$this->name        = isset($data['name'])        ? $data['name']        : '';
		$this->label       = isset($data['label'])       ? $data['label']       : '';
		$this->default     = isset($data['default'])     ? $data['default']     : '';
		$this->required    = isset($data['required'])    ? $data['required']    : false;
		$this->message     = isset($data['message'])     ? $data['message']     : '';
		$this->width       = isset($data['width'])       ? $data['width']       : null;
		$this->placeholder = isset($data['placeholder']) ? $data['placeholder'] : '';
		$this->options     = isset($data['options'])     ? $data['options']     : [];
		$this->min         = isset($data['min'])         ? $data['min']         : 0;
		$this->max         = isset($data['max'])         ? $data['max']         : 0;
		$this->step        = isset($data['step'])        ? $data['step']        : 0;
		$this->format      = isset($data['format'])      ? $data['format']      : '';
	}

	public function html() {
		return '';
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : $this->default;
	}

	public function validate() {
		if ($this->required)
			return !empty($this->value());
		else
			return true;
	}

	public function save() {
		return $this->value();
	}
}
