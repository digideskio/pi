<?php

namespace Pi\Lib;

class Pagination extends BaseMod implements IteratorAggregate {
	protected $first;
	protected $last;
	protected $prev;
	protected $next;
	protected $nbTotal;
	protected $nbByPage;
	protected $actual;
	protected $nbPages;

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

	public function getFirstPage() {
		return $this->first;
	}

	public function getLastPage() {
		return $this->last;
	}

	public function getPreviousPage() {
		return $this->prev;
	}

	public function getActualPage() {
		return $this->actual;
	}

	public function getNextPage() {
		return $this->next;
	}

	public function getNbTotal() {
		return $this->nbTotal;
	}

	public function getNbByPage() {
		return $this->nbByPage;
	}

	public function getNbPages() {
		return $this->nbPages;
	}
	
	public function isActualPage($i) {
		return $this->actual == $i;
	}
	
	public function getIterator() {
		for ($i = $this->first ; $i <= $this->last ; $i++)
			yield $i;
	}
}
