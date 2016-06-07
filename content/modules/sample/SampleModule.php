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

namespace Module\Sample;

use Module\Core\Field\TextField;
use Pi\Core\Module;

class SampleModule extends Module {
	public function initialize() {
		// Créer un nouveau modèle
		/*
		$this->registerModel(
			'test',
			__DIR__ . '/add-model/model.json',
			__DIR__ . '/add-model/view.html');
		*/

		// Créer un nouveau champ
		/*
		$this->registerField(
			'test',
			MyTestField::class);
		*/

		// Surcharger un modèle
		/*
		$this->overrideModel(
			'all',
			__DIR__ . '/override-model/all.json',
			__DIR__ . '/override-model/all.html');
		*/

		// Surcharger la vue d'un modèle
		/*
		$this->overrideViewModel(
			'all',
			__DIR__ . '/override-view-model/all.html');
		*/

		// Surcharger un champ
		/*
		$this->overrideField(
			'text',
			MyTextField::class);
		*/
	}
}

class MyTestField extends TextField { }
class MyTextField extends TextField { }
