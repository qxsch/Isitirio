<?php

namespace Isitirio\Core;

use Isitirio\Core\Group\GroupInterface,
    Isitirio\Core\Group\GroupMemberList,
    Isitirio\Core\User\UserInterface;

interface UserGroupProviderInterface {
	public function selectGroupsByUser(string $username) : \Traversable;
	public function selectUsersByGroup(string $groupname) : \Traversable;

	public function deleteGroup(GroupInterface $group);
	public function saveGroup(GroupInterface $group);
	public function groupExists(string $groupname);

	public function saveGroupMembers(GroupMemberList $members);

	public function deleteUser(UserInterface $user);
	public function saveUser(UserInterface $user);
	public function userExists(string $username);
}

