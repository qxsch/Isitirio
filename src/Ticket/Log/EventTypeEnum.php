<?php

namespace Isitirio\Ticket\Log;

use Isitirio\BaseTypes\GenericEnum;

class EventTypeEnum extends GenericEnum {
	const Message = 1;
	const WorkflowTransition = 2;
	const FieldCreation = 3;
	const FieldModification = 4;
	const FieldDeletion = 5;
}

