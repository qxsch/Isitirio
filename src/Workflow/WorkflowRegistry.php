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

		if($this->hasWorkflowByName($workflow->getName())) {
			throw new OutOfBoundsException("The Workflow with name \"$type\" has already been registered.");
		}
		foreach($supportedTicketTypes as $type) {
			$type = (string) $type;
			if($this->hasWorkflowByTicketType($type)) {
				throw new OutOfBoundsException("The Ticket Type \"$type\" has already been registered.");
			}
		}

		// all checks passed -> add to registry

		foreach($supportedTicketTypes as $type) {
			$type = (string) $type;
			self::$ticketType[$type] = $workflow;
		}
		self::$workflowNames[$workflow->getName()] = $workflow;
	}

	public static function clearWorkflows() {
		self::$ticketType = array();
		self::$workflowNames = array();
	}

	public static function getWorkflowByTicketType(string $type) : ?Workflow {
		if(isset(self::$ticketType[$type])) {
			return self::$ticketType[$type];
		}
		return null;
	}

	public static function hasWorkflowByTicketType(string $type) : bool {
		return isset(self::$ticketType[$type]);
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

