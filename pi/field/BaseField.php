<?php

namespace Pi\Field;

abstract class BaseField {
	protected static $num = 0;

	public $name;
	public $label;
	protected $default;
	protected $required;
	protected $message;
	protected $placeholder;
	protected $options;
	protected $min;
	protected $max;
	protected $step;
	protected $format;

  public function __construct($data) {
		self::$num++;

		$this->name        = isset($data['name'])        ? $data['name']        : '';
		$this->label       = isset($data['label'])       ? $data['label']       : '';
		$this->default     = isset($data['default'])     ? $data['default']     : '';
		$this->required    = isset($data['required'])    ? $data['required']    : false;
		$this->message     = isset($data['message'])     ? $data['message']     : '';
		$this->placeholder = isset($data['placeholder']) ? $data['placeholder'] : '';
		$this->options     = isset($data['options'])     ? $data['options']     : [];
		$this->min         = isset($data['min'])         ? $data['min']         : 0;
		$this->max         = isset($data['max'])         ? $data['max']         : 0;
		$this->step        = isset($data['step'])        ? $data['step']        : 0;
		$this->format      = isset($data['format'])      ? $data['format']      : '';
  }

	public function html() {
		return '';
	}

	public function validate() {
		if ($this->required)
			return !empty($this->value());
		else
			return true;
	}

	public function value() {
		return isset($_POST[$this->name]) ? $_POST[$this->name] : $this->default;
	}

	public function save() {
		return $this->value();
	}
}
