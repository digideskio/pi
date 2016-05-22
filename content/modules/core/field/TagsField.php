<?php

namespace Module\Core\Field;

use Pi\Model\Field\BaseField;
use Pi\Lib\Html\Tag;

class TagsField extends BaseField {
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
		$tag = new Tag('input', [
			'name'  => $this->name,
			'type'  => 'text',
			'value' => $this->value(),
			'id'    => 'input-' . $this->id
		]);

		if ($this->required)
			$tag->addAttr('required');

		if ($this->placeholder)
			$tag->addAttr('placeholder', $this->placeholder);

		return $tag;
	}
}
