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

namespace Module\Core;

use Pi\Core\Module;

class CoreModule extends Module {
	public function initialize() {
		$this->registerField('checkboxes', Field\CheckboxesField::class);
		$this->registerField('choice', Field\ChoiceField::class);
		$this->registerField('color', Field\ColorField::class);
		$this->registerField('date', Field\DateField::class);
		$this->registerField('email', Field\EmailField::class);
		$this->registerField('file', Field\FileField::class);
		$this->registerField('number', Field\NumberField::class);
		$this->registerField('password', Field\PasswordField::class);
		$this->registerField('radio', Field\RadioField::class);
		$this->registerField('range', Field\RangeField::class);
		$this->registerField('slug', Field\SlugField::class);
		$this->registerField('tags', Field\TagsField::class);
		$this->registerField('tel', Field\TelField::class);
		$this->registerField('textarea', Field\TextareaField::class);
		$this->registerField('text', Field\TextField::class);
		$this->registerField('time', Field\TimeField::class);
		$this->registerField('title', Field\TitleField::class);
		$this->registerField('url', Field\UrlField::class);
		$this->registerField('user', Field\UserField::class);
		$this->registerField('version', Field\VersionField::class);

		/*
		$this->registerModel(
			'all',
			__DIR__ . DS . 'models' . DS . 'all' . DS . 'model.json',
			__DIR__ . DS . 'models' . DS . 'all' . DS . 'view.html');
		*/

		$this->registerModelFromClass(
			'article',
			Model\ArticleModel::class);

		$this->registerModelFromClass(
			'page',
			Model\PageModel::class);
	}
}
