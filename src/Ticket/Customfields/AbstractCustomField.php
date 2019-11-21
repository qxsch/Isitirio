<?php
namespace Isitirio\Ticket\Customfields;

abstract class Customfield {
	private $id;
	private $name;
	private $value;
	private $configuration;

	public function __construct(int $id, string $name, $value, array $configuration=array()) {
		$this->id = $id;
		$this->name = $name;
		$this->value = $value;
		$this->configuration = $configuration;
	}

	public function getId() : int {
		return $this->id;
	}

	public function getConfiguration() : array {
		return $this->cconfiguration;
	}

	public function getName() {
		return $this->name;
	}

	public function getValue() {
		return $this->value;
	}
	public function setValue($value) {
		$this->value = $value;
	}

	abstract public function receiveHtmlValue($value);
	abstract public function getPreviewFieldHtml();
	abstract public function getEditableFieldHtml();
}
