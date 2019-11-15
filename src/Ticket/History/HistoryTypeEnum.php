<?php

namespace Isitirio\Ticket\History;

use Isitirio\BaseTypes\GenericEnum;

class HistoryTypeEnum extends GenericEnum {
	const Message = 1;
	const WorkflowTransition = 2;
	const FieldCreation = 3;
	const FieldModification = 4;
	const FieldDeletion = 5;
}

