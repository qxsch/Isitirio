<?php
namespace Isitirio\BaseTypes;

use SplDoublyLinkedList,
    InvalidArgumentException,
    Isitirio\NotImplementedException;

abstract class AbstractTypedList extends SplDoublyLinkedList {
	abstract protected function throwOnInvalidInstance($object);

	public function pop() {
		$value = parent::pop();
		if(method_exists($this, 'onDelete')) {
			$this->onDelete($value);
		}
		return $value;
	}

	public function shift() {
		$value = parent::shift();
		if(method_exists($this, 'onDelete')) {
			$this->onDelete($value);
		}
		return $value;
	}

	public function offsetUnset($index) {
		if($this->offsetExists($index)) {
			$value = $this->offsetGet($index);
			parent::offsetUnset($index);
			if(method_exists($this, 'onDelete')) {
				$this->onDelete($value);
			}
		}
		else {
			parent::offsetUnset($index);
		}
		return;
	}

	public function add($index, $newval) {
		$this->throwOnInvalidInstance($newval);
		parent::add($index, $newval);
		if(method_exists($this, 'onUpdate')) {
			$this->onUpdate($newval);
		}
	}
	public function offsetSet($index, $newval) {
		$this->throwOnInvalidInstance($newval);
		parent::offsetSet($index, $newval);
		if(method_exists($this, 'onUpdate')) {
			$this->onUpdate($newval);
		}
	}
	public function unshift($value) {
		$this->throwOnInvalidInstance($value);
		parent::unshift($value);
		if(method_exists($this, 'onUpdate')) {
			$this->onUpdate($value);
		}
	}
	public function push($value) {
		$this->throwOnInvalidInstance($value);
		parent::push($value);
		if(method_exists($this, 'onUpdate')) {
			$this->onUpdate($value);
		}
	}

	public function unserialize($serialized) { throw new NotImplementedException('Not supported'); }
	public function serialize() { throw new NotImplementedException('Not supported'); }

}

