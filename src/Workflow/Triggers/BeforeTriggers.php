<?php

namespace Isitirio\Workflow\Triggers;

use Isitirio\Workflow\Events\EventInterface;

class BeforeTriggers {
	public static function test(EventInterface $event, array $configuration) {
echo "hi\n";
	}
}
