<?php

namespace Isitirio;

trait ConfigSetterTrait {
	protected $config = null;

	public function getConfig() : ?Yaml {
		return $this->config;
	}
	public function setConfig(Yaml $config) {
		$this->config = $config;
		return $this;
	}
}

