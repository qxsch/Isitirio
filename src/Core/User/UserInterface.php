<?php

namespace Isitirio\Core\User;

use Isitirio\Core\Group\GroupList;

interface UserInterface {
	public function getUsername() : string;

	public function isEnabled() : bool;

	public function getImageUrl() : string;

	public function getGivennmae() : string;

	public function getLastname() : string;

	public function getEmail() : string;

	public function getGroups() : GroupList;
}

