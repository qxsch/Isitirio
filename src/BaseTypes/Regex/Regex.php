<?php
namespace Isitirio\BaseTypes\Regex;

class Regex {
	private $pattern;

	public function __construct($pattern) {
		$this->pattern = (string)$pattern;
	}

	public function match($str, int $offset=0) : ?Regex\Match {
		if(\preg_match($this->pattern, (string)$str, $m, PREG_OFFSET_CAPTURE, $offset)) {
			return new Match($m);
		}
		return null;
	}

	public function matchAll($str, int $offset=0) : ?Regex\Matches {
		if(\preg_match_all($this->pattern, (string)$str, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER, $offset)) {
			return new Matches($m);
		}
		return null;
	}

	public function replace($str, $replacement, int $limit=-1) : string {
		if($replacement instanceof \Closure) {
			$val = \preg_replace_callback($this->pattern, $replacement, $this->str, $limit, $this->c);
		}
		else {
			$val = \preg_replace($this->pattern, (string)$replacement, $this->str, $limit, $this->c);
		}
		if($val === null || $val === false) {
			switch(preg_last_error()) {
				case PREG_INTERNAL_ERROR:
					new \RuntimeException('Failed with error: PREG internal error');
				case PREG_BACKTRACK_LIMIT_ERROR:
					new \RuntimeException('Failed with error: PREG backtrack limit error (see "pcre.backtrack_limit" in php.ini)');
				case PREG_RECURSION_LIMIT_ERROR:
					new \RuntimeException('Failed with error: PREG recursion limit error (see "pcre.recursion_limit" in php.ini)');
				case PREG_BAD_UTF8_ERROR:
					new \RuntimeException('Failed with error: PREG bad UTF8 error');
				case PREG_BAD_UTF8_OFFSET_ERROR:
					new \RuntimeException('Failed with error: PREG bad UTF8 offset error');
				case PREG_JIT_STACKLIMIT_ERROR:
					new \RuntimeException('Failed with error: PREG JIT stack limit error');
			}
			new \RuntimeException('Failed with error: unknown (' . preg_last_error() . ')');
		}
		return $val;
	}
}

