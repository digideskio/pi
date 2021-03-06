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

class Pagination implements \IteratorAggregate {
	/** @var int */
	protected $first;

	/** @var int */
	protected $last;

	/** @var int */
	protected $prev;

	/** @var int */
	protected $next;

	/** @var int */
	protected $nbTotal;

	/** @var int */
	protected $nbByPage;

	/** @var int */
	protected $actual;

	/** @var int */
	protected $nbPages;

	/**
	 * Construit une pagination
	 */
	public function __construct(int $nbTotal,
	                            int $nbByPage,
	                            int $actual = 1,
	                            int $firstPage = 1) {
		$this->first    = $firstPage;
		$this->last     = ceil($nbTotal / $nbByPage);
		$this->actual   = max($this->first, min($this->last, $actual));
		$this->prev     = max($this->first, min($this->last, $this->actual - 1));
		$this->next     = max($this->first, min($this->last, $this->actual + 1));
		$this->nbTotal  = $nbTotal;
		$this->nbByPage = $nbByPage;
		$this->nbPages  = $this->last - $this->first;
	}

	/**
	 * Numéro de la première page
	 */
	public function getFirstPage(): int {
		return $this->first;
	}

	/**
	 * Numéro de la dernière page
	 */
	public function getLastPage(): int {
		return $this->last;
	}

	/**
	 * Numéro de la page précédente
	 */
	public function getPreviousPage(): int {
		return $this->prev;
	}

	/**
	 * Numéro de la page actuelle
	 */
	public function getActualPage(): int {
		return $this->actual;
	}

	/**
	 * Numéro de la page suivante
	 */
	public function getNextPage(): int {
		return $this->next;
	}

	/**
	 * Nombre d'éléments
	 */
	public function getNbTotal(): int {
		return $this->nbTotal;
	}

	/**
	 * Nombre d'éléments par page
	 */
	public function getNbByPage(): int {
		return $this->nbByPage;
	}

	/**
	 * Nombre de pages
	 */
	public function getNbPages(): int {
		return $this->nbPages;
	}

	/**
	 * La page $i est-elle la page actuelle ?
	 */
	public function isActualPage(int $i): bool {
		return $this->actual == $i;
	}

	/**
	 * Générateur
	 */
	public function getIterator(): \Generator {
		for ($i = $this->first ; $i <= $this->last ; $i++)
			yield $i;
	}
}
