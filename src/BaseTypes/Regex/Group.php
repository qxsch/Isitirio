<?php
namespace Isitirio\BaseTypes\Regex;

class Group  {
	private $start;
	private $stop;
	private $val;
	private $name;

	public function __construct(array $regexArr, string $name = '') {
		if(!isset($regexArr[0]) && !isset($regexArr[1])) {
			throw new \InvalidArgumentException('Invalid Arugemnt');
		}
		$this->start = $regexArr[1];
		$this->stop =  $regexArr[1] + \strlen($regexArr[0]);
		$this->val = $regexArr[0];
		$this->name = $name;
	}

	public function name() : string {
		return $this->name;
	}

	public function get() : string {
		return $this->val;
	}

	public function value() : string {
		return $this->val;
	}

	public function start() : int {
		return $this->start;
	}

	public function stop() : int {
		return $this->stop;
	}

	public function __toString() {
		return
			"Name:  " . $this->name  . "\n" .
			"Value: " . $this->val   . "\n" .
			"Start: " . $this->start . "\n" .
			"Stop:  " . $this->stop  . "\n" 
		;
	}
}

