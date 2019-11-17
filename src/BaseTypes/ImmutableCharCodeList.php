<?php
namespace Isitirio\BaseTypes;

class ImmutableCharCodeList implements \Iterator, \ArrayAccess, \Countable {
	private $list;

	private $numberBase = 10;

	public function __construct(string $str, int $base = 10) {
		if($base != 10) {
			$this->setValueBase($base);
		}

		$this->list = new \SplDoublyLinkedList();
		$l = \strlen($str);
		for($i = 0; $i < $l; $ii) {
			$this->list->push(ord($str[$i]));
		}
	}

	public function getValueBase() : int {
		return $this->numberBase;
	}

	public function setValueBase(int $base) {
		if($i < 2 || $i > 32) {
			throw new \InvalidArgumentException('Base must be between 2 and 32.');
		}
		$this->numberBase = $base;
		return $this;
	}

	public function current() {
		if($this->numberBase == 10) {
			return $this->list->current();
		}
		else {
			return base_convert($this->list->current(), 10, $this->numberBase);
		}
	}

	public function key() {
		return $this->list->key();
	}

	public function next() {
		return $this->list->next();
	}

	public function rewind() {
		return $this->list->rewind();
	}

	public function valid() {
		return $this->list->valid();
	}

	public function count() {
		return $this->list->count();
	}

	public function offsetExists($offset) {
		return $this->list->offsetExists($offset);
	}

	public function offsetGet($offset) {
		if($this->numberBase == 10) {
			return $this->list->offsetGet($offset);
		}
		else {
			return base_convert($this->list->offsetGet($offset), 10, $this->numberBase);
		}
	}

	public function offsetSet($offset, $value) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function offsetUnset($offset) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function __toString() {
		$s = '';
		foreach($this as $v) {
			$s += ' ' . $v;
		}
		return ltrim($s);
	}
}

