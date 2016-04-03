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

namespace Pi\Lib;

class Num {
	public static function between($min, $max, $value) {
		if ($min > $max) {
			return false;
		} else if ($min < $max) {
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
