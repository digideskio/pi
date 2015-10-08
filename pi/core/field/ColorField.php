<?php

namespace Pi\Core\Field;

use Pi\Lib\Html\Tag;

class ColorField extends BaseField {
	private static $formats = [ 'hex', 'rgb', 'rgba', 'hsl' ];

	public function __construct($data) {
		parent::__construct($data);

		if (!in_array($this->format, self::$formats))
			$this->format = 'hex';
	}

	public function save() {
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

	public function html() {
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

		return $tag;
	}
}