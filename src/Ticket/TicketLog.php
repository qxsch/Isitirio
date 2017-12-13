<?php
namespace Isitirio\Ticket;

use Isitirio\Ticket\Log\LogEventInterface;

class TicketLog {
	private $ticket;

	public function __construct(Ticket $ticket) {
		$this->ticket = $ticket;
	}

	public function getTicket() : Ticket {
		return $this->ticket;
	}

	public function append(LogEventInterface $event) {
		
	}
}

