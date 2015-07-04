<?php

namespace Pi\Lib;

class Flash {
	public static function init() {
		if (!isset($_SESSION['errors']))
			$_SESSION['errors']  = [];

		if (!isset($_SESSION['success']))
			$_SESSION['success'] = [];
	}

	public static function clean() {
		$_SESSION['errors']  = [];
		$_SESSION['success'] = [];
	}

	public static function pushError($error) {
		array_push($_SESSION['errors'], $error);
	}

	public static function pushSuccess($success) {
		array_push($_SESSION['success'], $success);
	}

	public static function hasErrors() {
		return count($_SESSION['errors']) > 0;
	}

	public static function hasNoErrors() {
		return !self::hasErrors();
	}

	public static function hasSuccess() {
		return count($_SESSION['success']) > 0;
	}

	public static function getErrors() {
		return $_SESSION['errors'];
	}

	public static function getSuccess() {
		return $_SESSION['success'];
	}
}
