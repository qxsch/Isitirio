<?php
namespace Isitirio\Workflow;

use LogicException,
    Isitirio\Workflow\Lists\TransitionList,
    Isitirio\Workflow\Events\ValidatorEvent,
    Isitirio\Workflow\Events\BeforeEvent,
    Isitirio\Workflow\Events\AfterEvent;


class WorkflowRegistry {
	private static $workflows;

	public static function getWorkflowByTicketType(string $ticketType) {
		$this->workflows = array();
	}
}

