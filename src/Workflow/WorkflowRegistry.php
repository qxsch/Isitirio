<?php
namespace Isitirio\Workflow;


class WorkflowRegistry {
	private static $ticketTypes = array();
	private static $workflowNames = array();
	private static $workflowLoaders = array();

	public static function addLazyWorkflowloader(WorkflowLoaderInterface $workflowloader) {
		self::$workflowLoaders[] = $workflowloader;
	}

	public static function addWorkflow(Workflow $workflow, array $supportedTicketTypes) {
		if(empty($supportedTicketTypes)) {
			throw new \LengthException("SupportedTicketTypes is empty.");
		}

		if(isset(self::$workflowNames[$workflow->getName()])) {
			throw new \LogicException("The Workflow with name \"" . $workflow->getName() . "\" has already been registered.");
		}
		foreach($supportedTicketTypes as $type) {
			$type = (string) $type;
			if(isset(self::$ticketTypes[$type])) {
				throw new \LogicException("The Ticket Type \"$type\" has already been registered.");
			}
		}

		// all checks passed -> add to registry

		foreach($supportedTicketTypes as $type) {
			$type = (string) $type;
			self::$ticketTypes[$type] = $workflow;
		}
		self::$workflowNames[$workflow->getName()] = $workflow;
	}

	public static function addSupportedTicketTypeToWorkflow(string $name, string $type) {
		if(!isset(self::$workflowNames[$name])) {
			throw new \LogicException("The Workflow with name \"$name\" is not registered.");
		}
		if(isset(self::$ticketTypes[$type])) {
			throw new \LogicException("The Ticket Type \"$type\" has already been registered.");
		}
		self::$ticketTypes[$type] = self::$workflowNames[$name];
	}

	public static function clearWorkflows() {
		self::$ticketTypes = array();
		self::$workflowNames = array();
	}

	public static function getWorkflowByTicketType(string $type) : ?Workflow {
		if(self::hasWorkflowByTicketType($type)) {
			return self::$ticketTypes[$type];
		}
		return null;
	}

	public static function hasWorkflowByTicketType(string $type) : bool {
		if(isset(self::$ticketTypes[$type])) {
			return true;
		}
		foreach(self::$workflowLoaders as $loader) {
			$loader->loadByTicketType($type);
			if(isset(self::$ticketTypes[$type])) {
				return true;
			}
		}
		return false;
	}

	public static function getWorkflowByName(string $name) : ?Workflow {
		if(self::hasWorkflowByName($name)) {
			return self::$workflowNames[$name];
		}
		return null;
	}

	public static function hasWorkflowByName(string $name) : bool {
		if(isset(self::$workflowNames[$name])) {
			return true;
		}
		foreach(self::$workflowLoaders as $loader) {
			$loader->loadByWorkflowName($name);
			if(isset(self::$workflowNames[$name])) {
				return true;
			}
		}
		return false;
	}
}

