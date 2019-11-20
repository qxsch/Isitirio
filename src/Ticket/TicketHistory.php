<?php
namespace Isitirio\Ticket;

use Isitirio\Ticket\History\HistoryEventInterface;

class TicketHistory implements \Countable, \IteratorAggregate {
	private $ticket;
	private $provider;

	public function __construct(Ticket $ticket) {
		$this->ticket = $ticket;
		$this->provider = History\ProviderRegistry::get();
	}

	public function getTicket() : Ticket {
		return $this->ticket;
	}

	public function append(HistoryEntryInterface $event) {
		return $this->provider->insert($ticket->getId(), $event);
	}

	public function get(int $offset=0, int $limit=50) {
		return $this->prvodier->select($ticket->getId(), $offset, $limit);
	}

	public function getIterator() {
		return $this->prvodier->select($ticket->getId());
	}

	public function count() : int {
		return $this->prvodier->selectCount($ticket->getId());
	}
}

