<?php
namespace Isitirio\Workflow\Events;

use Isitirio\Ticket\Ticket,
    Isitirio\Workflow\Workflow,
    Isitirio\Workflow\Transition;

interface EventInterface {
	public function getWorkflow() : Workflow;
	public function getTransition() : Transition;
	public function getTicket() : Ticket;

	public function isBlocked() : bool;
	public function setBlocked(bool $blocked);

	public function stopPropagation();
	public function isPropagationStopped() : bool;
}

