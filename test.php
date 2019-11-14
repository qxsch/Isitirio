#!/usr/bin/env php
<?php

require_once('test-setup.php');


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

