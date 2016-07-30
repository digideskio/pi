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

class DateField extends Field {
	/**
	 * Zone de saisie d'une date
	 */
	public function __construct(array $data = []) {
		parent::__construct($data);

		if ($this->default == 'today')
			$this->default = strftime('%Y-%m-%d', time());
	}

	/**
	 * @inheritdoc
	 */
	public function validate(): bool {
		$value = $this->value();
		$regex = '~[0-9]{4}(-[0-9]{1,2}){2}~'; // yyyy-mm-dd

		if ($this->required) {
			if (preg_match($regex, $value))
				return true;
			else
				return false;
		} else {
			if (empty($value))
				return true;
			elseif (preg_match($regex, $value))
				return true;
			else
				return false;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function html(): string {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'date',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return (string) $tag;
	}
}
