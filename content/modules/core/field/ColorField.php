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

class ColorField extends Field {
	/** @var string[] */
	protected static $formats = [ 'hex', 'rgb', 'rgba', 'hsl' ];

	/**
	 * Zone de saisie d'une couleur
	 */
	public function __construct(array $data = []) {
		parent::__construct($data);

		if (!in_array($this->format, static::$formats))
			$this->format = 'hex';
	}

	/**
	 * @inheritdoc
	 */
	public function save(): string {
		if (in_array($this->format, [ 'rgb', 'rgba' ])) {
			$value = $this->value();
			$value = str_replace('#', '', $value);

			$values = str_split($value, 2);

			$rgb = [];

			foreach ($values as $value)
				$rgb[] = hexdec($value);

			switch (count($rgb)) {
				case 3:
					$rgb = 'rgb('
						. $rgb[0] . ', '
						. $rgb[1] . ', '
						. $rgb[2] . ')';
					break;

				case 4:
					$rgb = 'rgba('
						. $rgb[0] . ', '
						. $rgb[1] . ', '
						. $rgb[2] . ', '
						. $rgb[3] . ')';
					break;

				default:
					$rgb = 'rgb(0, 0, 0)';
			}

			return $rgb;
		}

		return $this->value();
	}

	/**
	 * @inheritdoc
	 */
	public function html(): string {
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'color',
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
