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

namespace Module\Core\Field;

use Pi\Core\Field;
use Pi\Lib\Html\Tag;

class TimeField extends Field {
	/** @var string[] */
	protected static $formats = [ 'hh:mm', 'hh:mm:ss' ];

	/**
	 * @param $data
	 */
	public function __construct(array $data = []) {
		parent::__construct($data);

		if (!in_array($this->format, static::$formats))
			$this->format = 'hh:mm';

		if ($this->default == 'now' && $this->format == 'hh:mm')
			$this->default = strftime('%H:%M', time());
		else
			$this->default = strftime('%H:%M:%S', time());
	}

	/**
	 * @inheritdoc
	 */
	public function validate(): bool {
		$value = $this->value();

		if ($this->format == 'hh:mm')
			$regex = '~[0-9]{1,2}:[0-9]{1,2}~'; // hh:mm
		else
			$regex = '~[0-9]{1,2}(:[0-9]{1,2}){2}~'; // hh:mm:ss

		if ($this->required) {
			if (preg_match($regex, $value))
				return true;
			else
				return false;
		} else {
			if (empty($value))
				return true;
			else if (preg_match($regex, $value))
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
			'type'  => 'time',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		if ($this->format == 'hh:mm:ss')
			$tag->addAttr('step', 1);

		return $tag;
	}
}
