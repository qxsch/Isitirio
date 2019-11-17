<?php
namespace Isitirio\BaseTypes\Regex;

class Matches implements \IteratorAggregate, \ArrayAccess, \Countable {
	private $matches;

	public function __construct(array $regexArr, string $name = '') {
		$this->matches = new \ArrayObject();
		foreach($regexArr as $k => $v) {
			$this->matches[$k] = new Match($v);
		}
	}


	public function getIterator() {
		return $this->matches->getIterator();
	}

	public function count() {
		return $this->matches->count();
	}

	public function offsetExists($offset) {
		return $this->matches->offsetExists($offset);
	}

	public function offsetGet($offset) {
		return $this->matches->offsetGet($offset);
	}

	public function offsetSet($offset, $value) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function offsetUnset($offset) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function __toString() {
		$s = "-- Matches --\n";
		foreach($this->matches as $m) {
			$s .= "  " . \rtrim(\str_replace("\n", "\n  ", $m)) . "\n";
		}
		return $s;
	}
}

