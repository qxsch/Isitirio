<?php
namespace Isitirio\Workflow;

interface WorkflowLoaderInterface {

	public function loadByTicketType($type);
	public function loadByWorkflowName($name);

