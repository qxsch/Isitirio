<?php
namespace Isitirio\Ticket;

use Isitirio\Workflow\WorkflowRegistry;

class TicketWorkflow {
	private $ticket;
	private $workflow;

	public function __construct(Ticket $ticket) {
		$this->ticket = $ticket;
		$this->workflow = WorkflowRegistry::getWorkflowByTicketType($ticket->getTicketType());
		if($this->workflow === null) {
			throw new \LogicException('Failed to lookup workflow for ticket type "' . $ticket->getTicketType() . '".');
		}
	}

	public function getTicket() : Ticket {
		return $this->ticket;
	}

        public function getName() : string {
		return $this->workflow->getName();
	}

        public function getInitialState() : string {
		return $this->workflow->getInitialState();
	}

        public function getTransitions() {
		return $this->workflow->getTransitions();
	}

        public function getEnabledTransitions() {
		return $this->workflow->getEnabledTransitions($this->ticket);
	}

        public function getEnabledTransitionNames() {
		return $this->workflow->getEnabledTransitionNames($this->ticket);
	}

        public function can(string $transitionName) : bool {
		return $this->workflow->can($this->ticket, $transitionName);
	}

        public function apply(string $transitionName) {
		return $this->workflow->apply($this->ticket, $transitionName);
	}
}	
