<?php
namespace Isitirio\Ticket;

use Isitirio\Workflow\WorkflowRegistry;

class Ticket {
	private $state;
	private $id;
	private $history = null;
	private $workflow = null;
	protected $summary = '';
	protected $description = '';
	protected $created = null;
	protected $modified = null;

	public function __construct(string $id, string $ticketType, string $state = '') {
		$this->id = $id;
		$this->ticketType = $ticketType;
		$this->state = $state;
		if($this->state == '') {
			$this->state = $this->getWorkflow()->getInitialState();
		}
	}

	public function setFromArray(array $arr) : int {
		$setCount = 0;
		if(isset($arr['summary'])) {
			$this->summary = (string)$arr['summary'];
			$setCount++;
		}
		if(isset($arr['description'])) {
			$this->description = (string)$arr['description'];
			$setCount++;
		}
		if(isset($arr['created'])) {
			$this->created = self::getImmutableDateTime($arr['created']);
			$setCount++;
		}
		if(isset($arr['modified'])) {
			$this->modified = self::getImmutableDateTime($arr['modified']);
			$setCount++;
		}

		return $setCount;
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
		if($this->workflow === null) {
			$this->workflow = new TicketWorkflow($this);
		}
		return $this->workflow;
	}

	public function getHistory() : TicketHistory {
		if($this->history === null) {
			$this->history = new TicketHistory($this);
		}
		return $this->history;
	}

	public function getSummary() : string {
		return $this->summary;
	}

	public function setSummary(string $summary) {
		$this->summary = $summary;
		return $this;
	}

	public function getDescription() : string {
		return $this->description;
	}

	public function setDescription(string $description) {
		$this->description = $description;
		return $this;
	}

	public static function getImmutableDateTime($dt) {
		if($dt instanceof \DateTimeImmutable) {
			return $dt;
		}
		elseif($dt instanceof \DateTime) {
			return \DateTimeImmutable::DateTimeImmutable($dt);
		}
		elseif(is_string($dt)) {
			return new \DateTimeImmutable($dt, \Isitirio\Defaults::getTimeZone());
		}
		elseif(is_int($dt)) {
			return new \DateTimeImmutable('@' . $dt , \Isitirio\Defaults::getTimeZone());
		}
		else {
			throw new \InvalidArgumentException('Just DateTimeImmutable, DateTime, string or int  are supported.');
		}
	}

	public function getCreated() : ?\DateTimeImmutable {
		return $this->created;
	}

	public function setCreated($created) {
		$this->created = self::getImmutableDateTime($created);
		return $this;
	}

	public function getModified() : ?\DateTimeImmutable {
		return $this->modified;
	}

	public function setModified($modified) {
		$this->modified = self::getImmutableDateTime($modified);
		return $this;
	}
}
