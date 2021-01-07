<?php

namespace Isitirio\Ticket\History;

class ProviderRegistryBuilder {
	private $yaml;
	private $clearRegistry;

	protected function __construct(Yaml $yaml, bool $clearRegistry) {
		$this->yaml = $yaml;
		$this->clearRegistry = $clearRegistry;
	}

	public function getYaml() {
		return $this->yaml;
	}

	public function isClearRegistry() {
		return $this->clearRegistry;
	}

	public function build() {
		throw new \BadMethodCallException('Not implemented.');
		//$this->yaml->get('');
	}
}

