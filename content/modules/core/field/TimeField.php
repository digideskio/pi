<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
use Pi\Lib\Html\Tag;

class TimeField extends BaseField {
	/** @var string[] */
	protected static $formats = [ 'hh:mm', 'hh:mm:ss' ];

	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);

		if (!in_array($this->format, self::$formats))
			$this->format = 'hh:mm';

		if ($this->default == 'now' && $this->format == 'hh:mm')
			$this->default = strftime('%H:%M', time());
		else
			$this->default = strftime('%H:%M:%S', time());
	}

	/**
	 * @inheritdoc
	 */
	public function validate() {
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
	public function html() {
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
