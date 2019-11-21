<?php

namespace Isitirio\Core\Group;

use Isitirio\Core\User\UserInterface,
    Isitirio\Core\UserGroupProviderRegistry;

class GroupList implements \Countable, \Iterator {
	private $user;
	private $groups = null;

	public function __construct(UserInterface $user) {
		$this->user = $user;
	}

	public function getUser() : UserInterface {
		return $this->user;
	}

	public function refresh() {
		$this->groups = new \SplDoublyLinkedList();
		foreach(UserGroupProviderRegistry::get()->selectGroupsByUser($this->user->getUsername()) as $g) {
			$this->groups->push($g);
		}
		return $this;
	}

	private function loadGroups() {
		if($this->groups === null) {
			$this->refresh();
		}
	}

	public function key() {
		return $this->groups->key();
	}

	public function next() {
		return $this->groups->next();
	}

	public function rewind() {
		$this->loadGroups();
		return $this->groups->rewind();
	}

	public function valid() {
		return $this->groups->valid();
	}

	public function count() {
		$this->loadGroups();
		return $this->groups->count();
	}
}

