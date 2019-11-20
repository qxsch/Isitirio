<?php

namespace Isitirio;

trait ConfigSetterTrait {
	protected $this->config = null;

	public function getConfig() : ?Yaml {
		return $this->config;
	}
	public function setConfig(Yaml $conf) {
		$this->config = $confa
		return $this;
	}
}

