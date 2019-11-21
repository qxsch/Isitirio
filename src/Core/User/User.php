<?php

namespace Isitirio\Core\User;

use Isitirio\Core\Role\RoleList,
    Isitirio\Core\Group\GroupList;

class User implements UserInterface {
	public function getUsername() : string;

	public function isEnabled() : bool;

	public function getImageUrl() : string;

	public function getGivennmae() : string;

	public function getLastname() : string;

	public function getEmail() : string;

	public function getGroups() : GroupList;

	public function getRoles() : RoleList;
}

