<?php

namespace Isitirio\Ticket\Log;

interface LogEventInterface {
	public function getEventType() : EventTypeEnum;
	public function getUsername() : string;
	public function getMessage() : string;
	public function getTime() : \DateTime;
}

