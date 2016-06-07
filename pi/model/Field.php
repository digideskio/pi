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

namespace Pi\Model;

use Exception;

abstract class Field {
	protected static $num = 0;

	/** @var int */
	public $id;

	/** @var string */
	public $name;

	/** @var string */
	public $label;

	/** @var string */
	public $default;

	/** @var bool */
	public $required;

	/** @var string */
	public $message;

	/** @var string */
	public $width;

	/** @var string */
	public $placeholder;

	/** @var array */
	public $options;

	/** @var int */
	public $min;

	/** @var int */
	public $max;

	/** @var int */
	public $step;

	/** @var string */
	public $format;

	/**
	 * Construit un champ
	 *
	 * @param array $array
	 *
	 * @return static
	 *
	 * @throws Exception
	 */
	public static function fromArray($array) {
		$field = new static();

		foreach ($array as $key => $value) {
			$setter = 'set' . ucfirst($key);

			if (method_exists($field, $setter))
				$field->$setter($value);
			else
				throw new Exception('No setter available for "' . $key . '"');
		}

		return $field;
	}

	/**
	 * @param $data
	 */
	public function __construct($data = []) {
		$this->id = ++static::$num;

		$this->name        = $data['name']        ?? '';
		$this->label       = $data['label']       ?? '';
		$this->default     = $data['default']     ?? '';
		$this->required    = $data['required']    ?? false;
		$this->message     = $data['message']     ?? '';
		$this->width       = $data['width']       ?? '1/1';
		$this->placeholder = $data['placeholder'] ?? '';
		$this->options     = $data['options']     ?? [];
		$this->min         = $data['min']         ?? 0;
		$this->max         = $data['max']         ?? 0;
		$this->step        = $data['step']        ?? 0;
		$this->format      = $data['format']      ?? '';
	}

	/**
	 * @return string
	 */
	abstract public function html();

	/**
	 * @return string
	 */
	public function value() {
		return $_POST[$this->name] ?? $this->default;
	}

	/**
	 * @return bool
	 */
	public function validate() {
		if ($this->required)
			return !empty($this->value());
		else
			return true;
	}

	/**
	 * @return string
	 */
	public function save() {
		return $this->value();
	}

	/**
	 * Définir le nom du champ
	 *
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Définir le label du champ
	 *
	 * @param string $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * Définir la valeur par défaut
	 *
	 * @param string $default
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * Définir si le champ est obligatoire ou non
	 *
	 * @param bool $required
	 */
	public function setRequired($required) {
		$this->required = $required;
	}

	/**
	 * Définir le message du champ
	 *
	 * @param string $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * Définir la largeur du champ
	 *
	 * @param string $width
	 */
	public function setWidth($width) {
		$this->width = $width;
	}

	/**
	 * Définir le « placeholder » du champ
	 *
	 * @param string $placeholder
	 */
	public function setPlaceholder($placeholder) {
		$this->placeholder = $placeholder;
	}

	/**
	 * Définir les valeurs disponibles pour ce champ
	 *
	 * @param array $options
	 */
	public function setOptions($options) {
		$this->options = $options;
	}

	/**
	 * Définir la valeur minimale que pour avoir le champ
	 *
	 * @param int|float $min
	 */
	public function setMin($min) {
		$this->min = $min;
	}

	/**
	 * Définir la valeur maximale que pour avoir le champ
	 *
	 * @param int|float $max
	 */
	public function setMax($max) {
		$this->max = $max;
	}

	/**
	 * Définir le pas du champ
	 *
	 * @param int|float $step
	 */
	public function setStep($step) {
		$this->step = $step;
	}

	/**
	 * Définir le format du champ
	 *
	 * @param string $format
	 */
	public function setFormat($format) {
		$this->format = $format;
	}
}
