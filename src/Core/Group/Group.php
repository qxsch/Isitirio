<?php

namespace Isitirio\Core\Group;

class Group implements GroupInterface {
	private $groupname;
	private $memberlist = null;

	public function __construct(string $groupname) {
		$this->groupname = $groupname;
	}

	public function getGroupname() : string {
		return $this->groupname;
	}

	public function getMembers() : GroupMemberList {
		if($this->memberlist === null) {
			$this->memberlist = new GroupMemberList($this);
		}
		return $this->memberlist;
	}
}

