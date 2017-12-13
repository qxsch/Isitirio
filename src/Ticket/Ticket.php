<?php
namespace Isitirio\Ticket;

use Isitirio\Workflow\WorkflowRegistry;

class Ticket {
	private $state;
	private $id;

	public function __construct(string $id, string $ticketType, string $state) {
		$this->id = $id;
		$this->ticketType = $ticketType;
		$this->state = $state;
		if($this->state == '') {
			$this->state = $this->getWorkflow()->getInitialState();
		}
	}

	public function getLog() {
		return new TicketLog($this);
	}

	public function getId() : string {
		return $this->id;
	}

	public function getTicketType() : string {
		return $this->ticketType;
	}

	public function getState() : string {
		return $this->state;
	}

	public function setState(string $state) {
		$this->state = $state;
	}

	public function getWorkflow() : TicketWorkflow {
		return new TicketWorkflow($this);
	}

}
