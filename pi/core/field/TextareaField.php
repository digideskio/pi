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

namespace Pi\Core\Field;

use Pi\Lib\Html\Tag;

class TextareaField extends BaseField {
	/** @var string[] */
	protected static $formats = [ 'text', 'markdown', 'twig', 'html' ];

	/**
	 * @param $data
	 */
	public function __construct($data) {
		parent::__construct($data);
	}

	/**
	 * @inheritdoc
	 */
	public function html() {
		$id = 'input-' . $this->id;

		$tag = new Tag('textarea', [
			'type' => 'text',
			'name' => $this->name,
			'id' => $id
		], $this->value());

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		if ($this->min > 0 && $this->min <= $this->max)
			$tag->addAttr('minlength', $this->min);

		if ($this->max > 0 && $this->max >= $this->min)
			$tag->addAttr('maxlength', $this->max);

		$tagField = (string) $tag;

		$tagField .= '
			<script>
				var editor = CodeMirror.fromTextArea(document.querySelector(\'#' . $id .'\'), {
					lineNumbers: true,
					mode: {
						name: \'' . $this->format . '\',
						htmlMode: true
					},
					indentWithTabs: true,
					tabSize: 2,
					lineWrapping: true,
					theme: \'neo\',
					extraKeys: {
						\'F11\': function(cm) {
							cm.setOption(\'fullScreen\', !cm.getOption(\'fullScreen\'));
						}
					}
				});
			</script>
		';

		if ($this->format == 'wysiwyg') {
			$tagField .= '
				<script>
					tinymce.init({
						selector: \'textarea\',
						language: \'fr_FR\',
						height: 500,
						theme: \'modern\',

						plugins: [
							\'advlist autolink lists link image hr\',
							\'searchreplace code fullscreen\',
							\'media table contextmenu\',
							\'textcolor imagetools\'
						],

						toolbar1: \'insertfile undo redo | styleselect | bold \' +
							\'italic underline strikethrough | alignleft \' +
							\'aligncenter alignright alignjustify | bullist \' +
							\'numlist outdent indent | link image\',

						toolbar2: \'media | forecolor backcolor code\',

						removed_menuitems: \'newdocument cut copy paste\'
					});
				</script>
			';
		}

		return $tagField;
	}
}
