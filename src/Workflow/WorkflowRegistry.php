<?php
namespace Isitirio\Workflow;

use LengthException,
    OutOfBoundsException;


class WorkflowRegistry {
	private static $ticketTypes = array();
	private static $workflowNames = array();

	public static function addWorkflow(Workflow $workflow, array $supportedTicketTypes) {
		if(empty($supportedTicketTypes)) {
			throw new LengthException("SupportedTicketTypes is empty.");
		}

		if(self::hasWorkflowByName($workflow->getName())) {
			throw new OutOfBoundsException("The Workflow with name \"$type\" has already been registered.");
		}
		foreach($supportedTicketTypes as $type) {
			$type = (string) $type;
			if(self::hasWorkflowByTicketType($type)) {
				throw new OutOfBoundsException("The Ticket Type \"$type\" has already been registered.");
			}
		}

		// all checks passed -> add to registry

		foreach($supportedTicketTypes as $type) {
			$type = (string) $type;
			self::$ticketTypes[$type] = $workflow;
		}
		self::$workflowNames[$workflow->getName()] = $workflow;
	}

	public static function clearWorkflows() {
		self::$ticketTypes = array();
		self::$workflowNames = array();
	}

	public static function getWorkflowByTicketType(string $type) : ?Workflow {
		if(isset(self::$ticketTypes[$type])) {
			return self::$ticketTypes[$type];
		}
		return null;
	}

	public static function hasWorkflowByTicketType(string $type) : bool {
		return isset(self::$ticketTypes[$type]);
	}

	public static function getWorkflowByName(string $name) : ?Workflow {
		if(isset(self::$workflowNames[$name])) {
			return self::$workflowNames[$name];
		}
		return null;
	}

	public static function hasWorkflowByName(string $name) : bool {
		return isset(self::$workflowNames[$name]);
	}
}

