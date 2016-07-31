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
class File {
	/** @var string Nom du fichier */
	private $fileName;

	/**
	 * @var Module Module associé (si aucun module associé : appartient au
	 * thème)
	 */
	private $module;

	/**
	 * Constructeur
	 */
	public function __construct(string $fileName, Module $module = null) {
		$this->fileName = $fileName;
		$this->module = $module;
	}

	/**
	 * Le fichier est-t-il associé à un module ?
	 */
	public function isAssociatedToModule(): bool {
		return $this->module != null;
	}

	/**
	 * Nom du fichier
	 */
	public function __toString(): string {
		return $this->fileName;
	}
}
