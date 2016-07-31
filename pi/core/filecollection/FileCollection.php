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

namespace Pi\Core\FileCollection;

use Pi\Core\App\Module;

/**
 * @todo Renommer la classe
 */
class FileCollection implements \IteratorAggregate {
	/** @var File[] Fichiers enregistrés */
	private $files;

	/**
	 * Constructeur
	 */
	public function __construct() {
		$this->files = [];
	}

	/**
	 * @todo Ajouter un vrai code de retour
	 *
	 * Enregistrer un fichier
	 */
	public function addFile(string $fileName, Module $module = null): bool {
		$this->files[] = new File($fileName, $module);

		return true;
	}

	/**
	 * La collection possède-t-elle le fichier $filename ?
	 */
	public function hasFile(string $fileName): bool {
		foreach ($this->files as $file)
			if ($file == $fileName)
				return true;

		return false;
	}

	/**
	 * Itérateur
	 */
	public function getIterator(): \ArrayIterator {
		return new \ArrayIterator($this->files);
	}
}
