<?php
namespace Isitirio\Backend;


class IssueStatus {
	private $status = null;
	public function __construct(string $status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus(string $status) {
		$this->status = $status;
	}
}
