<?php
namespace Isitirio\Workflow\Events;

class BeforeEvent extends WorkflowEvent {
	public function setBlocked(bool $blocked) {
		throw new MethodNotSupportedException("Before events do not support blocking. Use validator events instead!");
	}
}

