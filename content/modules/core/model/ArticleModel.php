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

class ArticleModel extends Model {
	public function __construct(Pi $app) {
		parent::__construct($app);

		$this->setTitle('Article');
		$this->setViewFilename(__DIR__ . '/views/article.html');

		$categories = $this->newField('checkboxes');
		$categories->setLabel('Catégories');
		$categories->setMessage('Organiser le contenu');
		$categories->setWidth('1/4');
		$categories->setOptions([
			'design' => 'Design',
			'programming' => 'Programmation',
			'graphics' => 'Graphisme'
		]);

		$date = $this->newField('date');
		$date->setLabel('Date de publication');
		$date->setMessage('Format : aaaa-mm-jj');
		$date->setWidth('1/4');
		$date->setDefault('today');
		$date->setRequired(true);

		$status = $this->newField('choice');
		$status->setLabel('Status de publication');
		$status->setWidth('1/4');
		$status->setDefault('draft');
		$status->setOptions([
			'draft' => 'Brouillon',
			'private' => 'Accessible via l\'URL',
			'public' => 'Public'
		]);

		$comments = $this->newField('radio');
		$comments->setLabel('Commentaires');
		$comments->setMessage('Activer les commentaires');
		$comments->setWidth('1/4');
		$comments->setDefault('no');
		$comments->setOptions([
			'no' => 'Non',
			'yes' => 'Oui'
		]);

		$content = $this->newField('textarea');
		$content->setLabel('Contenu');
		$content->setRequired(true);

		$this->addField('categories', $categories);
		$this->addField('date', $date);
		$this->addField('status', $status);
		$this->addField('comments', $comments);
		$this->addField('content', $content);
	}
}
