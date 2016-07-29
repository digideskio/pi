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

namespace Pi\Core\Page;

class PageOutputter {
	/** @var Page */
	private $page;

	/**
	 * Constructeur
	 *
	 * @param Page $page
	 */
	public function __construct(Page $page) {
		$this->page = $page;
	}

	/**
	 * Représentation JSON de la page
	 *
	 * @return string Représentation JSON de la page
	 */
	public function json(): string {
		$arr = [];

		$arr['title'] = $this->page->getTitle();
		$arr['model'] = $this->page->getModel();
		$arr['created_at'] = $this->page->getCreatedAt()->format(\DateTime::ISO8601);
		$arr['updated_at'] = $this->page->getUpdatedAt()->format(\DateTime::ISO8601);
		$arr['fields'] = [];

		foreach ($this->page->getFields() as $fieldName => $field)
			$arr['fields'][$fieldName] = (string) $field;

		return json_encode($arr);
	}
}
