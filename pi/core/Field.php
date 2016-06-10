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

namespace Pi\Core;

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
	 * @param $array
	 *
	 * @throws Exception
	 */
	public static function fromArray(array $array): Field {
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
	public function __construct(array $data = []) {
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
	 * Contenu HTML du champ
	 */
	abstract public function html(): string;

	/**
	 * Récupérer la valeur du champ
	 */
	public function value(): string {
		return $_POST[$this->name] ?? $this->default;
	}

	/**
	 * @return true si le champ est valide (respecte toutes les conditions), false sinon
	 */
	public function validate(): bool {
		if ($this->required)
			return !empty($this->value());
		else
			return true;
	}

	/**
	 * @return Valeur du champ
	 */
	public function save(): string {
		return $this->value();
	}

	/**
	 * Définir le nom du champ
	 *
	 * @param $name Nom du champ
	 */
	public function setName(string $name) {
		$this->name = $name;
	}

	/**
	 * Définir le label du champ
	 *
	 * @param $label Label du champ
	 */
	public function setLabel(string $label) {
		$this->label = $label;
	}

	/**
	 * Définir la valeur par défaut
	 *
	 * @param $default Valeur par défaut du champ
	 */
	public function setDefault(string $default) {
		$this->default = $default;
	}

	/**
	 * Définir si le champ est obligatoire ou non
	 *
	 * @param $required true si le champ est requis, false sinon
	 */
	public function setRequired(bool $required) {
		$this->required = $required;
	}

	/**
	 * Définir le message du champ
	 *
	 * @param $message Message du champ
	 */
	public function setMessage(string $message) {
		$this->message = $message;
	}

	/**
	 * Définir la largeur du champ
	 *
	 * @param $width Largeur du champ
	 */
	public function setWidth(string $width) {
		$this->width = $width;
	}

	/**
	 * Définir le « placeholder » du champ
	 *
	 * @param $placeholder
	 */
	public function setPlaceholder(string $placeholder) {
		$this->placeholder = $placeholder;
	}

	/**
	 * Définir les valeurs disponibles pour ce champ
	 *
	 * @param $options Valeurs disponibles pour ce champ
	 */
	public function setOptions(array $options) {
		$this->options = $options;
	}

	/**
	 * Définir la valeur minimale que pour avoir le champ
	 *
	 * @param int|float $min Valeur minimale que pour avoir le champ
	 */
	public function setMin(float $min) {
		$this->min = $min;
	}

	/**
	 * Définir la valeur maximale que peut avoir le champ
	 *
	 * @param int|float $max Valeur maximale que peut avoir le champ
	 */
	public function setMax(float $max) {
		$this->max = $max;
	}

	/**
	 * Définir le pas du champ
	 *
	 * @param int|float $step Pas du champ
	 */
	public function setStep(float $step) {
		$this->step = $step;
	}

	/**
	 * Définir le format du champ
	 *
	 * @param $format Formati du champ
	 */
	public function setFormat(string $format) {
		$this->format = $format;
	}
}
