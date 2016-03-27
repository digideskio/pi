<?php

namespace Pi\Core\Field;

use Pi\Lib\Html\Tag;

class TextareaField extends BaseField {
	private static $formats = [ 'text', 'markdown', 'twig', 'html' ];

	public function __construct($data) {
		parent::__construct($data);
	}

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

		return $tagField;
	}
}
