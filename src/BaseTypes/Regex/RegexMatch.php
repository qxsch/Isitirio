<?php
namespace Isitirio\BaseTypes\Regex;

class RegexMatch  {
	private $start;
	private $stop;
	private $groups;

	public function __construct(array $regexArr) {
		if(!isset($regexArr[0][0]) && !isset($regexArr[0][1])) {
			throw new \InvalidArgumentException('Invalid Arugemnt');
		}
		$this->start = $regexArr[0][1];
		$this->stop =  $regexArr[0][1] + \strlen($regexArr[0][0]);

		$this->groups = new RegexGroups($regexArr);
	}

	public function groups() : RegexGroups {
		return $this->groups;
	}

	public function start() : int {
		return $this->start;
	}

	public function stop() : int {
		return $this->stop;
	}

	public function __toString() {
		$s =
			"-- Match --\n" .
			"Start: " . $this->start . "\n" .
			"Stop:  " . $this->stop  . "\n" .
			"Groups:\n"
		;
		foreach($this->groups as $k => $v) {
			$s .= "  Group $k:\n    " . \rtrim(\str_replace("\n", "\n    ", $v)) ."\n";
		}
		return $s;
	}
}

