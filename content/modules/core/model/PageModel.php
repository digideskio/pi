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

namespace Module\Core\Model;

use Pi\Core\App\Pi;
use Pi\Core\Model\Model;

class PageModel extends Model {
	public function __construct(Pi $app) {
		parent::__construct($app);

		$this->setTitle('Page');
		$this->setViewFilename(__DIR__ . '/views/page.html');

		$content = $this->newField('textarea');
		$content->setLabel('Contenu');
		$content->setFormat('twig');

		$this->addField('content', $content);
	}
}
