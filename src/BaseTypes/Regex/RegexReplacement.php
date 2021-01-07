<?php
namespace Isitirio\BaseTypes\Regex;

class RegexReplacement {
	public function __construct(
		private string $newStr,
		private int $replacements,
		private null|string $oldStr
	) {
	}

	public function get() : string {
		return $this->newStr;
	}

	public function getResult() : string {
		return $this->newStr;
	}

	public function getInput() : null|string {
		return $this->oldStr;
	}

	public function getReplacements() : int {
		return $this->replacements;
	}

	public function __toString() {
		return
			"-- Replacement --\n" .
			( $this->oldStr === null ? "" :  "Input:        " . $this->oldStr . "\n" ) .
			"Result:       " . $this->newStr . "\n" .
			"Replacements: " . $this->replacements . "\n"
		;
	}
}

