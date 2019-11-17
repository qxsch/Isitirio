<?php
namespace Isitirio\BaseTypes\Regex;

class Groups implements \IteratorAggregate, \ArrayAccess, \Countable {
	private $groups;

	public function __construct(array $regexArr, string $name = '') {
		$this->groups = new \ArrayObject();
		foreach($regexArr as $k => $v) {
			$this->groups[$k] = new Group($v, $k);
		}
	}


	public function getIterator() {
		return $this->groups->getIterator();
	}

	public function count() {
		return $this->groups->count();
	}

	public function offsetExists($offset) {
		return $this->groups->offsetExists($offset);
	}

	public function offsetGet($offset) {
		return $this->groups->offsetGet($offset);
	}

	public function offsetSet($offset, $value) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function offsetUnset($offset) {
		throw new \LogicException('You cannot modify an immutable type');
	}
}

