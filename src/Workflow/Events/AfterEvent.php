<?php
namespace Isitirio\Workflow\Events;

class AfterEvent  extends WorkflowEvent {
	public function setBlocked(bool $blocked) {
		throw new MethodNotSupportedException("After events do not support blocking. Use validator events instead!");
	}
}

