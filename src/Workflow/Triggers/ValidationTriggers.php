<?php

namespace Isitirio\Workflow\Triggers;

use Isitirio\Workflow\Events\EventInterface;

class ValidationTriggers {
	public static function BlockAfterTimeout(EventInterface $event, array $configuration) {
		// $configuration:
		//     CreatedTimeout: 90d
		//     UpdatedTimeout: 14d

	}
}
