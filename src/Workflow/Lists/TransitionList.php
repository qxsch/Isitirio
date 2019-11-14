<?php
namespace Isitirio\Workflow\Lists;

use InvalidArgumentException,
    SplObjectStorage,
    Isitirio\Workflow\Transition,
    Isitirio\BaseTypes\AbstractTypedList;

class TransitionList extends AbstractTypedList {
	private $fromStates = array();
	private $toStates = array();

	protected function onUpdate($value) {
		if($value instanceof Transition) {
			$from = strtolower($value->getFrom());
			$to = strtolower($value->getTo());
			if(!isset($this->fromStates[$from])) $this->fromStates[$from] = new SplObjectStorage();
			if(!isset($this->toStates[$to])) $this->toStates[$to] = new SplObjectStorage();
			$this->fromStates[$from]->attach($value);
			$this->toStates[$to]->attach($value);
		}
	}

	protected function onDelete($value) {
		if($value instanceof Transition) {
			$from = strtolower($value->getFrom());
			$to = strtolower($value->getTo());
			if(isset($this->fromStates[$from])) {
				$this->fromStates[$from]->detach($value);
				if($this->fromStates[$from]->count()<=0) unset($this->fromStates[$from]);
			}
			if(isset($this->toStates[$to])) {
				$this->toStates[$to]->detach($value);
				if($this->toStates[$to]->count()<=0) unset($this->toStates[$to]);
			}
		}
	}

	protected function throwOnInvalidInstance($object) {
		if(!($object instanceof Transition)) {
			throw new InvalidArgumentException("Value is not an instance of Isitirio\Workflow\Transition");
		}
		$from = strtolower($object->getFrom());
		$to = strtolower($object->getTo());
		if(isset($this->fromStates[$from]) && $this->fromStates[$from]->contains($object)) {
			throw new InvalidArgumentException("This Transition is already in the list.");
		}
		if(isset($this->toStates[$to]) && $this->toStates[$to]->contains($object)) {
			throw new InvalidArgumentException("This Transition is already in the list.");
		}
	}

	public function getStates() {
		$array=array();
		foreach(array_keys($this->fromStates) as $key) $array[$key]=true;
		foreach(array_keys($this->toStates) as $key) $array[$key]=true;
		return array_keys($array);
	}


	public function hasTransitionsFrom(string $fromName) {
		return isset($this->fromStates[$fromName]);
	}

	public function getTransitionsFrom(string $fromName) {
		$result = [];
		$fromName=strtolower($fromName);
		if(isset($this->fromStates[$fromName])) {
			foreach($this->fromStates[$fromName] as $transition) {
				$result[] = $transition;
			}
		}
		return $result;
	}

	public function hasTransitionsTo(string $toName) {
		return isset($this->toStates[$toName]);
	}

	public function getTransitionsTo(string $toName) {
		$result = [];
		$toName=strtolower($toName);
		if(isset($this->toStates[$toName])) {
			foreach($this->toStates[$toName] as $transition) {
				$result[] = $transition;
			}
		}
		return $result;
	}
}

