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

use Pi\Core\App;

App::registerField('checkboxes', Field\CheckboxesField::class);
App::registerField('choice', Field\ChoiceField::class);
App::registerField('color', Field\ColorField::class);
App::registerField('date', Field\DateField::class);
App::registerField('email', Field\EmailField::class);
App::registerField('file', Field\FileField::class);
App::registerField('number', Field\NumberField::class);
App::registerField('password', Field\PasswordField::class);
App::registerField('radio', Field\RadioField::class);
App::registerField('range', Field\RangeField::class);
App::registerField('slug', Field\SlugField::class);
App::registerField('tags', Field\TagsField::class);
App::registerField('tel', Field\TelField::class);
App::registerField('textarea', Field\TextareaField::class);
App::registerField('text', Field\TextField::class);
App::registerField('time', Field\TimeField::class);
App::registerField('title', Field\TitleField::class);
App::registerField('url', Field\UrlField::class);
App::registerField('user', Field\UserField::class);
App::registerField('version', Field\VersionField::class);
