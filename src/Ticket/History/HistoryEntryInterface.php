<?php

namespace Isitirio\Ticket\History;

interface HistoryEntryInterface {
	public function getHistoryType() : HistoryTypeEnum;
	public function getTime() : \DateTime;
	public function getUsername() : string;
	public function getTitle() : string;
	public function getMessage() : string;
	public function getOldValue();
	public function getNewValue();
}

