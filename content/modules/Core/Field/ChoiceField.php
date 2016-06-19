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

class ChoiceField extends Field {
	/**
	 * @param $data
	 */
	public function __construct(array $data = []) {
		parent::__construct($data);
	}

	/**
	 * @inheritdoc
	 */
	public function html(): string {
		$val = $this->value();

		$html = '<select name="' . $this->name . '"' . ($this->required ? ' required' : '') . ' id="input-' . $this->id . '">';

		foreach ($this->options as $key => $value) {
		 	$selected = $key == $val ? ' selected' : '';

			$html .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
		}

		$html .= '</select>';

		return $html;
	}
}
