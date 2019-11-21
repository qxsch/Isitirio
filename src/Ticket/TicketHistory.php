<?php
namespace Isitirio\Ticket;

use Isitirio\Ticket\History\HistoryEventInterface;

class TicketHistory implements \Countable, \IteratorAggregate {
	private $ticket;

	public function __construct(Ticket $ticket) {
		$this->ticket = $ticket;
	}

	public function getTicket() : Ticket {
		return $this->ticket;
	}

	public function append(HistoryEntryInterface $event) {
		return History\ProviderRegistry::get()->insert($this->ticket->getId(), $event);
	}

	public function get(int $offset=0, int $limit=50) {
		return History\ProviderRegistry::get()->select($this->ticket->getId(), $offset, $limit);
	}

	public function getIterator() {
		return History\ProviderRegistry::get()->select($this->ticket->getId());
	}

	public function count() : int {
		return History\ProviderRegistry::get()->selectCount($this->ticket->getId());
	}
}

