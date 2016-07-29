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

class FileSystem {
	/**
	 * Supprimer un dossier
	 *
	 * @see http://stackoverflow.com/questions/7288029/php-delete-directory-that-is-not-empty#answer-7288067
	 *
	 * @param string $dir Dossier à supprimer
	 *
	 * @return bool Succès
	 */
	public static function removeDirectory(string $dir): bool {
		$result = true;

		$it = new \RecursiveDirectoryIterator($dir);
		$it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
		foreach($it as $file) {
			if ('.' === $file->getBasename() || '..' ===  $file->getBasename())
				continue;
			if ($file->isDir())
				$result &= rmdir($file->getPathname());
			else
				$result &= unlink($file->getPathname());
		}

		$result &= rmdir($dir);

		return $result;
	}
}
