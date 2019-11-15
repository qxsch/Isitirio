<?php
namespace Isitirio\Ticket;

use Isitirio\Ticket\History\HistoryEventInterface;

class TicketHistory implements \Countable, \Iterator {
	private $ticket;

	public function __construct(Ticket $ticket) {
		$this->ticket = $ticket;
	}

	public function getTicket() : Ticket {
		return $this->ticket;
	}

	public function append(HistoryEntryInterface $event) {
		
	}

	public function get($offset=0, $limit=50) {
	}

	public function count() : int {
		return 0;
	}

	public function current() {
		return null;
	}

	public function key() {
		return null;
	}

	public function next() {
	}

	public function rewind() {
	}

	public function valid() : bool {
		return false;
	}
}

