<?php

namespace Isitirio\Core\Group;

interface GroupInterface {
	public function getGroupname() : string;

	public function getMembers() : GroupMemberList;
}

