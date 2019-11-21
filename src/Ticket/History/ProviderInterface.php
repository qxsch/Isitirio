<?php

namespace Isitirio\Ticket\History;

interface ProviderInterface {
	public function insert(string $ticketId, HistoryEventInterface $event);

	public function select(string $ticketId, int $offset=-1, int $limit=-1) : \Traversable;

	public function selectCount(string $ticketId) : int;
}

