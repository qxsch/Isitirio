<?php
namespace Isitirio\BaseTypes;

class ImmutableByteString implements StringInterface {
	private $str;
	private $c = 0;
	private $pos = 0;


	public function __construct($str, $c=0) {
		$this->str = (string)$str;
		$this->c = (int)$c;
	}

	public function get() : string {
		return $this->str;
	}

	public function getLastOperationCount() : int {
		return (int)$this->c;
	}

	public function prepend($str) : StringInterface {
		return new static((string)$str . $this->str);
	}

	public function append($str) : StringInterface {
		return new static($this->str . (string)$str);
	}

	public function insertAt(int $offset, $str) : StringInterface {
		if(!$this->offsetExists($offset)) {
			if($offset == $this->count()) {
				return $this->append($str);
			}
			throw new \OutOfBoundsException('The offset is not within the string.');
		}
		return new static(\substr($this->str, 0, $offset) . ((string)$str) . \substr($this->str, $offset));
	}

	public function trim($mask=null) : StringInterface {
		if($mask === null) {
			return new static(trim($this->str));
		}
		return new static(trim($this->str, $mask));
	}

	public function ltrim($mask=null) : StringInterface {
		if($mask === null) {
			return new static(\ltrim($this->str));
		}
		return new static(\ltrim($this->str, $mask));
	}

	public function rtrim($mask=null) : StringInterface {
		if($mask === null) {
			return new static(\rtrim($this->str));
		}
		return new static(\rtrim($this->str, $mask));
	}

	public function replace($pattern, $replacement) : StringInterface {
		$val = \str_replace($pattern, $replacement, $this->str, $this->c);
		return new static($val, $this->c);
	}

	public function replaceRegex($pattern, $replacement, int $limit=-1) : StringInterface {
		if($replacement instanceof \Closure) {
			$val = \preg_replace_callback((string)$pattern, $replacement, $this->str, $limit, $this->c);
		}
		else {
			$val = \preg_replace((string)$pattern, (string)$replacement, $this->str, $limit, $this->c);
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
		return new static($val, $this->c);
	}

	public function splitRegex($pattern, int $limit = -1) : array {
		$arr = array();
		foreach(\preg_split((string)$pattern, $this->str, $limit) as $a) {
			$arr[] = new static($a);
		}
		return $arr;
	}

	public function matchRegex($pattern, int $offset=0) : ?Regex\Match {
		if(\preg_match($pattern, $this->str, $m, PREG_OFFSET_CAPTURE, $offset)) {
			return new Regex\Match($m);
		}
		return null;
	}

	public function matchAllRegex($pattern, int $offset=0) : ?Regex\Matches {
		if(\preg_match_all($pattern, $this->str, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER, $offset)) {
			return new Regex\Matches($m);
		}
		return null;
	}

	public function substr(int $start, int $length=null) : StringInterface {
		if($length === null) {
			$val = \substr($this->str, $start, $length);
		}
		else {
			$val = \substr($this->str, $start);
		}
		if($val === null || $val === false) {
			new \RuntimeException('Substr failed.');
		}
		return new static($val);
	}

	public function substring(int $start, int $length=null) : StringInterface {
		return $this->substr($start, $length);
	}

	public function explode($delimiter, int $limit = PHP_INT_MAX) : array {
		$arr = array();
		foreach(\explode((string)$delimiter, $this->str, $limit) as $a) {
			$arr[] = new static($a);
		}
		return $arr;
	}

	public function split($delimiter, int $limit = PHP_INT_MAX) : array {
		return $this->explode((string)$delimiter, $limit);
	}

	public static function implode($glue, array $pieces) : StringInterface {
		return new static(\implode((string)$glue, $pieces));
	}

	public function join(array $pieces) : StringInterface {
		return static::implode($this->str, $pieces);
	}

	public function charAt(int $offset) : string {
		if(!$this->offsetExists($offset)) {
			throw new \OutOfBoundsException('The offset is not within the string.');
		}
		return $this->str[$index];
	}

	public function charCodeListAt(int $offset) : ImmutableCharCodeList {
		return new ImmutableCharCodeList($this->charAt($offset));
	}

	public function charCodeAt(int $offset) : int {
		return \ord($this->charAt($offset));
	}


	/**
	 * Does the string contain another string
	 * @param string|StringInterface|array $needle the haystack should contain (array of multiple needles is supported, where at least one must be found)
	 * @return bool true in case the haystack starts with needle
	 */
	public function contains($needle) : bool{
		if(\is_array($needle)) {
			foreach($needle as $n) {
				$n = (string)$n;
				if($n === "" || \strpos($this->str, $n) !== FALSE) {
					return true;
				}
			}
			return false;
		}
		else {
			$needle = (string)$needle;
			return $needle === "" || \strpos($this->str, $needle) !== FALSE;
		}
	}

	/**
	 * Does the string start with another string?
	 * @param string|StringInterface $needle the haystack should begin with
	 * @return bool true in case the haystack starts with needle
	 */
	public function startsWith($needle) : bool {
		$needle = (string)$needle;
		// search backwards starting from haystack length characters from the end
		return $needle === "" || \strrpos($this->str, $needle, - \strlen($this->str)) !== FALSE;
	}

	/**
	 * Does the string end with another string?
	 * @param string|StringInterface $needle the haystack should end with
	 * @return bool true in case the haystack ends with needle
	 */
	public function endsWith($needle) : bool {
		$needle = (string)$needle;
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = \strlen($this->str) - \strlen($needle)) >= 0 && \strpos($this->str, $needle, $temp) !== FALSE);
	}

	public function toUpper() : StringInterface {
		return new static(\strtoupper($this->str));
	}

	public function toLower() : StringInterface {
		return new static(\strtolower($this->str));
	}

	/**
	 * Get the length of the string in bytes
	 *
	 * ATTETION FOR MULTIBYTE CHARSET ENCODINGS:
	 *     to get the length the string in locigal chars,
	 *     use the count method
	 * @return int the length of the string in bytes
	 */
	public function byteLength() : int {
		return $this->count();
	}

	public function equals($str) : bool {
		return $this->str == ((string)$str);
	}
	
	public function spaceship($str) : int {
		return $this->str <=> ((string)$str);
	}

	public function current() {
		if($this->pos >= 0 && $this->pos < $this->count()) {
			return $this->str[$this->pos];
		}
		return null;
	}

	public function key() {
		return $this->pos;
	}

	public function next() {
		$this->pos++;
	}

	public function rewind() {
		$this->pos = 0;
	}

	public function valid() {
		return $this->pos < $this->count();
	}

	public function count() {
		return \strlen($this->str);
	}

	public function offsetExists($offset) {
		if(!is_int($offset)) {
			if(!ctype_digit($offset)) {
				throw new \InvalidArgumentException('Offset is not an integer.');
			}
			$offset = (int)$offset;
		}
		return $offset >= 0 && $offset < $this->count();
	}

	public function offsetGet($offset) {
		if(!$this->offsetExists($offset)) {
			throw new \OutOfBoundsException('The offset is not within the string.');
		}
		return $this->str[(int)$offset];
		
	}

	public function offsetSet($offset, $value) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function offsetUnset($offset) {
		throw new \LogicException('You cannot modify an immutable type');
	}

	public function __toString() {
		return $this->str;
	}
}

