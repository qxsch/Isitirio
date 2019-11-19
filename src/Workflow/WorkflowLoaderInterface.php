<?php
namespace Isitirio\Workflow;

interface WorkflowLoaderInterface {
	public function loadByTicketType(string $type);
	public function loadByWorkflowName(string $name);
}
