#!/usr/bin/env php
<?php

require_once('autoload.php');
require_once('vendor/autoload.php');


$yaml = Isitirio\Yaml::createFromArray(Symfony\Component\Yaml\Yaml::parseFile("test.yaml"));


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
/*echo $yaml->dump();
echo $yaml->dump(true);


echo "---------\n";

echo $yaml->get('Workflows.Monitoring Workflow.InitialState');
echo "\n";

echo $yaml['Workflows']['Monitoring Workflow']['InitialState'];
echo "\n";

foreach($yaml['Workflows'] as $key => $v) {
	echo " - $key\n";
}

echo $yaml->get('Workflows.Monitoring Workflow.InitialState');


echo "\n";*/





Isitirio\Workflow\WorkflowRegistryBuilder::buildFromYaml($yaml, 'Workflows');



echo "\n";

