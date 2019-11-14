<?php
namespace Isitirio\Workflow;

use Isitirio\Workflow\Lists\TriggerList;

class Transition {
	private $name;
	private $from;
	private $to;

	private $validationTriggers;
	private $beforeTriggers;
	private $afterTriggers;

	public function __construct(string $name, string $from, string $to) {
		$this->name = $name;
		$this->from = $from;
		$this->to = $to;
		$this->validationTriggers = new TriggerList();
		$this->beforeTriggers = new TriggerList();
		$this->afterTriggers = new TriggerList();
	}

	public function getName() : string {
		return $this->name;
	}

	public function getFrom() : string {
		return $this->from;
	}

	public function getTo() : string {
		return $this->to;
	}

	public function getValidationTriggers() {
		return $this->validationTriggers;
	}

	public function getBeforeTriggers() {
		return $this->beforeTriggers;
	}

	public function getAfterTriggers() {
		return $this->afterTriggers;
	}
}

