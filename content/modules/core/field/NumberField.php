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

use Pi\Core\Field;
use Pi\Lib\Html\Tag;
use Pi\Lib\Num;

class NumberField extends Field {
	/**
	 * @param $data
	 */
	public function __construct(array $data = []) {
		parent::__construct($data);

		$this->min  = $data['min'] ?? 0;
		$this->max  = $data['max'] ?? 100;
		$this->step = $data['step'] ?? 1;
	}

	/**
	 * @inheritdoc
	 */
	public function value(): string {
		return (int) parent::value();
	}

	/**
	 * @inheritdoc
	 */
	public function validate(): bool {
		$value = $this->value();

		if ($this->required || !empty($value))
			return Num::between($this->min, $this->max, $value);
		else
			return true;
	}

	/**
	 * @inheritdoc
	 */
	public function html(): string {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'number',
			'value' => $this->value(),
			'min'   => $this->min,
			'max'   => $this->max,
			'step'  => $this->step,
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
