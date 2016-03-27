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

use Pi\Lib\Html\Tag;

class RangeField extends BaseField {
	public function __construct($data) {
		parent::__construct($data);

		$this->min  = isset($data['min'])  ? $data['min']  : 0;
		$this->max  = isset($data['max'])  ? $data['max']  : 100;
		$this->step = isset($data['step']) ? $data['step'] : 1;
	}

	public function value() {
		return (int) parent::value();
	}

	public function validate() {
		$value = $this->value();

		if ($this->required || !empty($value))
			return Num::between($this->min, $this->max, $value);
		else
			return true;
	}

	public function html() {
    $tag = new Tag('input', [
			'name'  => $this->name,
      'type'  => 'range',
      'min'   => $this->min,
      'max'   => $this->max,
      'step'  => $this->step,
      'value' => $this->value(),
			'id'    => 'input-' . $this->id
    ]);

    return $tag;
	}
}
