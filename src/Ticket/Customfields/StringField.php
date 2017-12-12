<?php
namespace Isitirio\Ticket\Customfields;

use Isitirio\Ticket\Customfields\Helpers\Html;

class StringField extends AbstractCustomField {

	public function receivePostValue($value) {
		$this->setValue((string)$value);
	}

	public function getPreviewFieldHtml() {
		return Html::Text($this);
	}

	public function getEditableFieldHtml() {
		return Html::Input($this);
	}
}
