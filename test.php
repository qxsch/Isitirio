#!/usr/bin/env php
<?php

require_once('vendor/autoload.php');
require_once('libs/IssueStatus.php');

/*
use Symfony\Component\Yaml\Yaml;
print_r(
	Yaml::parseFile('test.yaml')
);
*/

use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore;


$definitionBuilder = new DefinitionBuilder();
$definition = $definitionBuilder->addPlaces(['draft', 'review', 'rejected', 'published'])
	// Transitions are defined with a unique name, an origin place and a destination place
	->addTransition(new Transition('to_review', 'draft', 'review'))
	->addTransition(new Transition('publish', 'review', 'published'))
	->addTransition(new Transition('reject', 'review', 'rejected'))
	->build()
;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

$dispatcher = new EventDispatcher();


// more info on events:   https://symfony.com/doc/current/workflow/usage.html
$dispatcher->addListener('workflow.Issue.guard', function (Event $event) {
	//echo "GUARD status ". $event->getSubject()->getStatus() .".... ".get_class($event)."\n";
	//echo "Workflow: ".$event->getWorkflowName()."\n";
	//  $event->setBlocked(true);  // disable this transition
});
$dispatcher->addListener('workflow.Issue.leave', function (Event $event) {
	echo "Leave status ". $event->getSubject()->getStatus() .".... ".get_class($event)."\n";
	echo "Workflow: ".$event->getWorkflowName()."\n";
	echo $event->getTransition()->getFroms()[0]  . " => " . $event->getTransition()->getTos()[0] ."\n";
});
$dispatcher->addListener('workflow.Issue.entered', function (Event $event) {
	echo "ENTERED status ". $event->getSubject()->getStatus() .".... ".get_class($event)."\n";
	echo "Workflow: ".$event->getWorkflowName()."\n";
	echo $event->getTransition()->getFroms()[0]  . " => " . $event->getTransition()->getTos()[0] ."\n";
});


$marking = new SingleStateMarkingStore('status');  // getStatus / setStatus Method  or status property
$workflow = new Workflow($definition, $marking, $dispatcher, 'Issue');



$o=new Isitirio\Backend\IssueStatus('draft');

echo "Can publish: "; var_dump($workflow->can($o, 'publish')); // False
echo "Can to_review: "; var_dump($workflow->can($o, 'to_review')); // True

$workflow->apply($o, 'to_review');
echo "Can publish: "; var_dump($workflow->can($o, 'publish')); // True
var_dump($workflow->getEnabledTransitions($o));;

