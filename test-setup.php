<?php

class test {
	public static function inject(array $configuration) {
		return new Isitirio\Workflow\Trigger(
			function(Isitirio\Workflow\Events\EventInterface $event, array $configuration) {
				echo "hi";
			},
			$configuration
		);

	}

	public static function callMe(Isitirio\Workflow\Events\EventInterface $event, array $configuration) {
		echo "called...\n";
	}
}

require_once('autoload.php');
require_once('vendor/autoload.php');

$yaml = Isitirio\Yaml::createFromArray(Symfony\Component\Yaml\Yaml::parseFile("test.yaml"));

Isitirio\Workflow\WorkflowRegistryBuilder::buildFromYaml($yaml, 'Workflows');

