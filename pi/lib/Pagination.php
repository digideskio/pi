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

use \IteratorAggregate;

class Pagination implements IteratorAggregate {
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
	 * @param int $nbTotal
	 * @param int $nbByPage
	 * @param int $actual
	 * @param int $firstPage
	 */
	public function __construct($nbTotal, $nbByPage, $actual = 1, $firstPage = 1) {
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
	 * @return int
	 */
	public function getFirstPage() {
		return $this->first;
	}

	/**
	 * @return int
	 */
	public function getLastPage() {
		return $this->last;
	}

	/**
	 * @return int
	 */
	public function getPreviousPage() {
		return $this->prev;
	}

	/**
	 * @return int
	 */
	public function getActualPage() {
		return $this->actual;
	}

	/**
	 * @return int
	 */
	public function getNextPage() {
		return $this->next;
	}

	/**
	 * @return int
	 */
	public function getNbTotal() {
		return $this->nbTotal;
	}

	/**
	 * @return int
	 */
	public function getNbByPage() {
		return $this->nbByPage;
	}

	/**
	 * @return int
	 */
	public function getNbPages() {
		return $this->nbPages;
	}

	/**
	 * @param int $i
	 *
	 * @return bool
	 */
	public function isActualPage($i) {
		return $this->actual == $i;
	}

	/**
	 * @return \Generator
	 */
	public function getIterator() {
		for ($i = $this->first ; $i <= $this->last ; $i++)
			yield $i;
	}
}
