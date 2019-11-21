<?php
namespace Isitirio\Ticket\Customfields;

use Isitirio\Ticket\Customfields\Helpers\Html,
    UnexpectedValueException;

class StringField extends AbstractCustomField {

	public function receiveHtmlValue($value) {
		$configuration = $this->getConfiguration();
		$value = (string)$value;
		if(!@$configuration['Multiline']) {
			if(
				(strpos($value, "\n") !== FALSE) ||
				(strpos($value, "\r") !== FALSE)
			) {
				throw new UnexpectedValueException('This field does not support multiline strings.');
			}
		}
		$this->setValue($value);
	}

	public function getPreviewFieldHtml() {
		return Html::Text($this);
	}

	public function getEditableFieldHtml() {
		$configuration = $this->getConfiguration();
		if(@$configuration['Multiline']) {
			return Html::Textarea($this);
		}
		else {
			return Html::Input($this);
		}
	}
}
