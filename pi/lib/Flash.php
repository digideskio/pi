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

namespace Pi\Lib;

/**
 * @todo Éviter le conflit possible avec la classe Session (à cause de
 *       l'utilisation commune de $_SESSION)
 */
class Flash {
	/**
	 * Initilisation du flash
	 */
	public function __construct() {
		if (!isset($_SESSION['errors']))
			$_SESSION['errors'] = [];

		if (!isset($_SESSION['success']))
			$_SESSION['success'] = [];
	}

	/**
	 * Nettoyage du flash
	 */
	public function clean() {
		$_SESSION['errors'] = [];
		$_SESSION['success'] = [];
	}

	/**
	 * @param $error Message d'erreur à insérer
	 */
	public function pushError(string $error) {
		array_push($_SESSION['errors'], $error);
	}

	/**
	 * @param $success Message de succès à insérer
	 */
	public function pushSuccess(string $success) {
		array_push($_SESSION['success'], $success);
	}

	/**
	 * Y a-t'-il des erreurs ?
	 *
	 * @return true s'il y a des erreurs, false sinon
	 */
	public function hasErrors(): bool {
		return count($_SESSION['errors']) > 0;
	}

	/**
	 * N'y a-t-il pas d'erreurs ?
	 *
	 * @return true s'il n'y a pas d'erreurs, false sinon
	 */
	public function hasNoErrors(): bool {
		return !$this->hasErrors();
	}

	/**
	 * Y a-t'-il des succès ?
	 *
	 * @return true s'il y a des succès, false sinon
	 */
	public function hasSuccess(): bool {
		return count($_SESSION['success']) > 0;
	}

	/**
	 * Récupérer les erreurs
	 *
	 * @return La liste des erreurs
	 */
	public function getErrors(): array {
		return $_SESSION['errors'];
	}

	/**
	 * Récupérer les succès
	 *
	 * @return La liste des succès
	 */
	public function getSuccess(): array {
		return $_SESSION['success'];
	}
}
