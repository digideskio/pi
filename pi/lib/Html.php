<?php

namespace Pi\Lib;

class Html {
	public static $inlineTags = [
		'br',
		'hr',
		'img',
		'input'
	];

	public static function tag($name, $attr = [], $content = '') {
		$html = '<' . $name;

		foreach ($attr as $key => $value)
			$html .= ' ' . $key . '="' . $value . '"';

		if (in_array($name, static::$inlineTags))
			$html .= ' />';
		else
			$html .= '>' . $content . '</' . $name . '>';
		
		return $html;
	}
}
