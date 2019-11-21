<?php

namespace Isitirio\Core\Group;

use Isitirio\Core\User\UserInterface,
    Isitirio\Core\UserGroupProviderRegistry;

class GroupMemberList implements \Countable, \Iterator {
	private $group;
	private $users = null;

	public function __construct(GroupInterface $group) {
		$this->group = $group;
	}

	public function getGroup() : GroupInterface {
		return $this->group;
	}

	public function contains(UserInterface $user) : bool {
		$this->loadUsers();
		foreach($this->users as $u) {
			if($u->getUsername() == $user->getUsername()) {
				return true;
			}
		}
		return false;
	}

	public function save() {
		return UserGroupProviderRegistry::get()->saveGroupMembers($this);
	}

	public function refresh() {
		$this->users = new \SplDoublyLinkedList();
		foreach(UserGroupProviderRegistry::get()->selectUsersByGroup($this->group->getGroupname()) as $g) {
			$this->users->push($g);
		}
		return $this;
	}

	private function loadUsers() {
		if($this->users === null) {
			$this->refresh();
		}
	}

	public function key() {
		return $this->users->key();
	}

	public function next() {
		return $this->users->next();
	}

	public function rewind() {
		$this->loadUsers();
		return $this->users->rewind();
	}

	public function valid() {
		return $this->users->valid();
	}

	public function count() {
		$this->loadUsers();
		return $this->users->count();
	}
}

