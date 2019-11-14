#!/usr/bin/env php
<?php

require_once('test-setup.php');


$ticket = new Isitirio\Ticket\Ticket(1234, 'it-incident', '');

echo "------ " . $ticket->getWorkflow()->getName() . " ------\n\n";
echo "Initial state  = "; var_dump($ticket->getWorkflow()->getInitialState());

$states = [];
$transitions = [];
foreach($ticket->getWorkflow()->getTransitions() as $tran) {
	if(!isset($states[$tran->getFrom()])) $states[$tran->getFrom()] = 0;
	$states[$tran->getFrom()]++;
	if(!isset($states[$tran->getTo()])) $states[$tran->getTo()] = 0;
	$transitions[] = "\t" . $tran->getName() . "\n\t\t" . $tran->getFrom() . '  =>  ' . $tran->getTo();
}

echo "States:\n";
foreach($states as $p => $c) {
	echo "\t$p";
	if($c < 1) echo "  (FINAL STATE)";
	if($ticket->getWorkflow()->getInitialState() == $p) echo "  (INITIAL STATE)";
	echo "\n";
}

echo "\nTransitions:\n";
foreach($transitions as $t) {
	echo "$t\n";
}

