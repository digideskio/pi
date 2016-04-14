<?php

namespace Pi;

class Loader {
	protected static $cssUrls = [];
	protected static $jsUrls = [];

	public static function loadCss($url) {
		static::$cssUrls[] = $url;
	}

	public static function loadJs($url) {
		static::$jsUrls[] = $url;
	}

	public static function getCssUrls() {
		return static::$cssUrls;
	}

	public static function getJsUrls() {
		return static::$jsUrls;
	}
}
