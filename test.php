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

Isitirio\Workflow\WorkflowRegistryBuilder::buildFromYaml($yaml, 'Workflows');


function showTicketStatusAndTransitions(Isitirio\Ticket\Ticket $ticket) {
	echo "CURRENT STATE: " . $ticket->getState() . "\n";
	echo "Next Transitions: ";
	print_r($ticket->getWorkflow()->getEnabledTransitionNames());
}

$ticket = new Isitirio\Ticket\Ticket(1234, 'it-incident', '');

echo "ID: " . $ticket->getId() . "\n";

showTicketStatusAndTransitions($ticket);

echo "\n\nTransition to: Start Progress  = "; var_dump($ticket->getWorkflow()->apply('Start Progress'));

showTicketStatusAndTransitions($ticket);

echo "\n\nTransition to: Close  = "; var_dump($ticket->getWorkflow()->apply('Close'));

showTicketStatusAndTransitions($ticket);

