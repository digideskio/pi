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

namespace Module\Core\Field;

use Pi\Core\Model\Field;
use Pi\Lib\Html\Tag;

class RadioField extends Field {
	/**
	 * Bouton radio, pour sélectionner une valeur parmi plusieurs
	 */
	public function __construct(array $data = []) {
		parent::__construct($data);

		if (count($this->options))
			$this->default = array_keys($this->options)[0];
	}

	/**
	 * @inheritdoc
	 */
	public function value(): string {
		if (!empty($this->value))
			return $this->value ?? '-';
		else
			return $this->default;
	}

	/**
	 * @inheritdoc
	 */
	public function html(): string {
		$html = '';

		$val = $this->value();

		foreach ($this->options as $key => $value) {
			$tag = new Tag('input', [
				'type'  => 'radio',
				'name'  => $this->name,
				'value' => $key,
				'id'    => 'input-' . $this->id
			]);

			if ($this->required)
				$tag->addAttr('required');

			if ($key == $val)
				$tag->addAttr('checked');

			$html .= $tag . ' <label for="input-' . $this->id . '">' . $value . '</label>';

			$this->id = ++static::$globalId;
		}

		return $html;
	}
}
