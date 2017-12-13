<?php
namespace Isitirio\Workflow\Events;

use Isitirio\Ticket\Ticket,
    Isitirio\Workflow\Workflow,
    Isitirio\Workflow\Transition;

class WorkflowEvent implements EventInterface {
	private $workflow;
	private $transition;
	private $ticket;
	private $blocked = false;
	private $stopPropagation = false;

	public function __construct(Workflow $workflow, Transition $transition, Ticket $ticket) {
		$this->workflow = $workflow;
		$this->transition = $transition;
		$this->ticket = $ticket;
	}

	public function getWorkflow() : Workflow {
		return $this->workflow;
	}

	public function getTransition() : Transition {
		return $this->transition;
	}

	public function getTicket() : Ticket {
		return $this->ticket;
	}

	public function isBlocked() : bool {
		return $this->blocked;
	}
	public function setBlocked(bool $blocked) {
		return $this->blocked = $blocked;
	}

	public function stopPropagation() {
		$this->stopPropagation = true;
	}

	public function isPropagationStopped() : bool {
		return $this->stopPropagation;
	}
}

