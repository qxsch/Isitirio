<?php
namespace Isitirio\Workflow;

use LogicException,
    Isitirio\Ticket\Ticket,
    Isitirio\Workflow\Lists\TransitionList,
    Isitirio\Workflow\Events\ValidatorEvent,
    Isitirio\Workflow\Events\BeforeEvent,
    Isitirio\Workflow\Events\AfterEvent;


class Workflow {
	private $name;
	private $initialState;
	private $transitions;

	public function __construct(string $name, string $initialState) {
		$this->name = $name;
		$this->initialState = $initialState;
		$this->transitions = new TransitionList();
	}

	public function getName() : string {
		return $this->name;
	}

	public function getInitialState() : string {
		return $this->initialState;
	}
	public function setInitialState(string $initialState) {
		$this->initialState = $initialState;
	}

	public function getTransitions() : TransitionList {
		return $this->transitions;
	}

	public function getEnabledTransitions(Ticket $ticket) : array {
		$result = array();
		foreach($this->transitions->getTransitionsFrom($ticket->getState()) as $transition) {
			$event = new ValidatorEvent($this, $transition, $ticket);
			foreach($transition->getValidationTriggers() as $trigger) {
				$trigger->callTrigger($event);
				// propagation stopped? 
				if($event->isPropagationStopped()) break;
			}
			// is the transition blocked? -> continue
			if($event->isBlocked()) continue;
			$result[] = $transition;
		}
		return $result;
	}

	public function getEnabledTransitionNames(Ticket $ticket) : array {
		$names = array();
		foreach($this->getEnabledTransitions($ticket) as $transition) {
			$names[strtolower($transition->getName())] = $transition->getName();
		}

		return array_values($names);
	}

	private function getFirstTransitionByName(Ticket $ticket, string $transitionName) {
		$result = array();
		$transitionName = strtolower($transitionName);
		foreach($this->transitions->getTransitionsFrom($ticket->getState()) as $transition) {
			// desired state?
			if(strtolower($transition->getName()) != $transitionName) continue;

			$event = new ValidatorEvent($this, $transition, $ticket);
			foreach($transition->getValidationTriggers() as $trigger) {
				$trigger->callTrigger($event);
				// propagation stopped? 
				if($event->isPropagationStopped()) break;
			}
			// is the transition blocked? -> continue with next transition
			if($event->isBlocked()) continue;
			return $transition;
		}
		return null;
	}

	public function can(Ticket $ticket, string $transitionName) : bool {
		$transiton = $this->getFirstTransitionByName($ticket, $transitionName, true);
		return $transiton !== null;
	}

	public function apply(Ticket $ticket, string $transitionName) {
		$transition = $this->getFirstTransitionByName($ticket, $transitionName, true);
		if($transition === null) {
			throw new LogicException('Cannot apply transition "' . $transitionName . '" on ticket "' . $ticket->getId() . '" for workflow "' . $this->name . '".');
		}

		if(!$this->runBeforeTriggers($ticket, $transition)) {
			return false;
		}

		$ticket->setState($transition->getTo());

		if(!$this->runAfterTriggers($ticket, $transition)) {
			return false;
		}

		return true;
	}

	private function runBeforeTriggers(Ticket $ticket, Transition $transition) {
		$event = new BeforeEvent($this, $transition, $ticket);
		foreach($transition->getBeforeTriggers() as $trigger) {
			$trigger->callTrigger($event);
			// propagation stopped? 
			if($event->isPropagationStopped()) break;
		}
		return !$event->isBlocked();
	}

	private function runAfterTriggers(Ticket $ticket, Transition $transition) {
		$event = new AfterEvent($this, $transition, $ticket);
		foreach($transition->getAfterTriggers() as $trigger) {
			$trigger->callTrigger($event);
			// propagation stopped? 
			if($event->isPropagationStopped()) break;
		}
		return !$event->isBlocked();
	}
}

