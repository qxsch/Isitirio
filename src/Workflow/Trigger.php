<?php
namespace Isitirio\Workflow;

use Isitirio\Workflow\Events\EventInterface;

class Trigger {
	private $call;
	private $configuration;

	public function __construct(Callable $call, array $configuration) {
		$this->call = $call;
		$this->configuration = $configuration;
	}

	public function callTrigger(EventInterface $event) {
		$call = $this->call;
		$call($event, $this->configuration);
	}
}

