<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
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
