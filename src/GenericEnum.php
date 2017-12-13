<?php

namespace Isitirio;

abstract class GenericEnum {
	private $name;
	private $value;

	public function __construct(string $name) {
		$this->set($name);
	}

	public function getValue() {
		return $this->value;
	}
	public function get() : string {
		return $this->name;
	}

	public function set(string $name) {
		$c = $this->getConstants();
		if(!isset($c[$name])) {
			throw new \DomainException('The constant "' . $name . '" does not exist in class "' . get_class($this) . '".');
		}
		$this->name = $name;
		$this->value = $c[$name];
	}

	public function __toString() {
		return $this->get();
	}

	public function getConstants() : array {
		return (new \ReflectionClass($this))->getConstants();
	}
}
