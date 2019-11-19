<?php

namespace Isitirio;

class ObjectBuilder {

	public static function buildFromConfig(Yaml $yaml) {
		if(!isset($yaml['Classname'])) {
			throw new \InvalidArgumentException('Configuration requires Classname.');
		}
		$c = new ReflectionClass($classname);
		if(isset($yaml['Arguments']) && $yaml['Arguments'] instanceof Yaml) {
			$obj = $c->newInstanceArgs($yaml['Arguments']->toArray());
		}
		else {
			$obj = $c->newInstanceArgs(array());
		}

		if($obj instanceof ConfigSetterInterface) {
			$obj->setConfig($yaml);
		}

		return $obj;
	}
}

