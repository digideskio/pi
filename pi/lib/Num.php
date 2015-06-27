<?php

namespace Pi\Lib;

class Num {
	public static function between($min, $max, $value) {
		if ($min > $max) {
			return false;
		} else if  ($min < $max) {
			return $value >= $min && $value <= $max;
		} else { // ($min == $max)
			if ($min == 0 && $max == 0) { // cas particulier où aucune borne n'est définie
				return true;
			} else {
				if ($value == $min && $value == $max)
					return true;
				else
					return false;
			}
		}
	}
}
