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

namespace Pi\Core\Model;

abstract class Field {
	/** @todo Ne pas utiliser de variables statiques */
	/** @var int */
	protected static $globalId = 0;

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

	/** @var string */
	public $value;

	/**
	 * Construit un champ
	 */
	public static function fromArray(array $array): Field {
		$field = new static();

		foreach ($array as $key => $value) {
			$setter = 'set' . ucfirst($key);

			if (method_exists($field, $setter))
				$field->$setter($value);
			else
				throw new \Exception('No setter available for "' . $key . '"');
		}

		return $field;
	}

	/**
	 * Constructeur
	 */
	public function __construct(array $data = []) {
		$this->id = ++static::$globalId;

		$this->name        = $data['name']        ?? 'input-' . $this->id;
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
		$this->value       = $data['value']       ?? '';
	}

	/**
	 * Contenu HTML du champ
	 */
	abstract public function html(): string;

	/**
	 * Récupérer la valeur du champ
	 */
	public function value() {
		return $this->value ?? $this->default;
	}

	/**
	 * Vérifie si la valeur du champ est valide selon les conditions définies
	 */
	public function validate(): bool {
		if ($this->required)
			return !empty($this->value());
		else
			return true;
	}

	/**
	 * Valeur du champ
	 */
	public function save(): string {
		return $this->value();
	}

	/**
	 * Définir le nom du champ
	 */
	public function setName(string $name): Field {
		$this->name = $name;

		return $this;
	}

	/**
	 * Définir le label du champ
	 */
	public function setLabel(string $label): Field {
		$this->label = $label;

		return $this;
	}

	/**
	 * Définir la valeur par défaut
	 */
	public function setDefault(string $default): Field {
		$this->default = $default;

		return $this;
	}

	/**
	 * Définir si le champ est obligatoire ou non
	 */
	public function setRequired(bool $required): Field {
		$this->required = $required;

		return $this;
	}

	/**
	 * Définir le message du champ
	 */
	public function setMessage(string $message): Field {
		$this->message = $message;

		return $this;
	}

	/**
	 * Définir la largeur du champ
	 */
	public function setWidth(string $width): Field {
		$this->width = $width;

		return $this;
	}

	/**
	 * Définir le « placeholder » du champ
	 */
	public function setPlaceholder(string $placeholder): Field {
		$this->placeholder = $placeholder;

		return $this;
	}

	/**
	 * Définir les valeurs disponibles pour ce champ
	 */
	public function setOptions(array $options): Field {
		$this->options = $options;

		return $this;
	}

	/**
	 * Définir la valeur minimale que pour avoir le champ
	 */
	public function setMin(float $min): Field {
		$this->min = $min;

		return $this;
	}

	/**
	 * Définir la valeur maximale que peut avoir le champ
	 */
	public function setMax(float $max): Field {
		$this->max = $max;

		return $this;
	}

	/**
	 * Définir le pas du champ
	 */
	public function setStep(float $step): Field {
		$this->step = $step;

		return $this;
	}

	/**
	 * Définir le format du champ
	 */
	public function setFormat(string $format): Field {
		$this->format = $format;

		return $this;
	}

	/**
	 * Définir la valeur du champ
	 */
	public function setValue($value): Field {
		$this->value = $value;

		return $this;
	}
}
