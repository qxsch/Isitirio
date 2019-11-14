<?php
namespace Isitirio\Workflow\Lists;

use InvalidArgumentException,
    Isitirio\Workflow\Trigger,
    Isitirio\BaseTypes\AbstractTypedList;

class TriggerList extends AbstractTypedList {
	protected function throwOnInvalidInstance($object) {
		if(!($object instanceof Trigger)) {
			throw new InvalidArgumentException("Value is not an instance of Isitirio\Workflow\Trigger");
		}
	}
}

