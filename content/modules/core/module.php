<?php

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
