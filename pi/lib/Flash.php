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

class Flash {
	/** @var Session Session */
	private $session;

	/**
	 * Initilisation du flash
	 */
	public function __construct(Session $session) {
		$this->session = $session;

		$this->clean();
	}

	/**
	 * Nettoyage du flash
	 */
	public function clean() {
		$this->session->set('errors', []);
		$this->session->set('successes', []);
	}

	/**
	 * Insérer un message d'erreur
	 */
	public function pushError(string $error) {
		$this->session->push('errors', $error);
	}

	/**
	 * Insérer un message de succès
	 */
	public function pushSuccess(string $success) {
		$this->session->push('successes', $success);
	}

	/**
	 * Y a-t'-il des erreurs ?
	 */
	public function hasErrors(): bool {
		return count($this->session->get('errors')) > 0;
	}

	/**
	 * N'y a-t-il pas d'erreurs ?
	 */
	public function hasNoErrors(): bool {
		return !$this->hasErrors();
	}

	/**
	 * Y a-t'-il des succès ?
	 */
	public function hasSuccesses(): bool {
		return count($this->session->get('successes')) > 0;
	}

	/**
	 * Récupérer les erreurs
	 */
	public function getErrors(): array {
		return $this->session->get('errors');
	}

	/**
	 * Récupérer les succès
	 */
	public function getSuccesses(): array {
		return $this->session->get('successes');
	}
}
