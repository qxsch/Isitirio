<?php

namespace Isitirio\Core;

use Isitirio\Core\Group\GroupInterface,
    Isitirio\Core\User\UserInterface;

interface UserGroupProviderInterface {
	public function selectGroupsByUser(string $username) : \Traversable;
	public function selectUsersByGroup(string $groupname) : \Traversable;

	public function deleteGroup(string $groupname);
	public function updateGroup(GroupInterface $group);
	public function GroupExists(string $groupname);

	public function deleteUser(string $username);
	public function updateUser(UserInterface $user);
	public function UserExists(string $username);
}

