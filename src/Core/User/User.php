<?php

namespace Isitirio\Core\User;

use Isitirio\Core\Group\GroupList,
    Isitirio\Core\UserGroupProviderRegistry;

class User implements UserInterface {
	private $username;
	private $enabled;
	private $givenname;
	private $lastname;
	private $email;
	private $grouplist = null;
	private $roles = array();

	public function __construct(
		string $username,
		bool $enabled = true,
		string $imageUrl = '',
		string $givenname = '',
		string $lastname = '',
		string $email = ''
	) {
		$this->username = $username;
		$this->enabled = $enabled;
		$this->imageUrl = $imageUrl;
		$this->givenname = $givenname;
		$this->lastname = $lastname;
		$this->email = $email;
	}

	public function getUsername() : string {
		return $this->username;
	}

	public function isEnabled() : bool {
		return $this->enabled;
	}
	public function setEnabled(bool $enabled) {
		$this->enabled = $enabled;
		return $this;
	}

	public function getImageUrl() : string {
		return $this->imageUrl;
	}

	public function setImageUrl(string $imageUrl) {
		$this->imageUrl = $imageUrl;
		return $this;
	}

	public function getGivenname() : string {
		return $this->givenname;
	}

	public function setGivenname(string $givenname) {
		$this->givenname = $givenname;
		return $this;
	}

	public function getLastname() : string {
		return $this->lastname;
	}

	public function setLastname(string $lastname) {
		$this->lastname = $lastname;
		return $this;
	}

	public function getEmail() : string {
		return $this->email;
	}

	public function setEmail(string $email) {
		$this->email = $email;
		return $this;
	}

	public function getGroups() : GroupList {
		if($this->grouplist === null) {
			$this->grouplist = new GroupList($this);
		}
		return $this->grouplist;
		
	}

	public function save() {
		return UserGroupProviderRegistry::get()->saveUser($this);
	}

	public function delete() {
		return UserGroupProviderRegistry::get()->deleteUser($this);
		
	}
}

