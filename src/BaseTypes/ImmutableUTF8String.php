<?php
namespace Isitirio\BaseTypes;

class ImmutableUTF8String implements StringInterface {
	private $str;
	private $c = 0;

	private $kpos = 0;
	private $pos = 0;
	private $cur = '';
	private $len = 0;

	public static function buildUTF8Array(&$str) {
		$l = \strlen($str);
		$a = array();
		for($pos = 0; $pos < $l; $pos++) {
			$a[] = self::readUTF8Char($str, $pos);
		}
		return $a;
	}

	public static function buildUTF8Sum(&$str) {
		$l = \strlen($str);
		$len = 0;
		for($pos = 0; $pos < $l; $pos++) {
			self::readUTF8Char($str, $pos);
			$len++;
		}
		return $len;
	}

	protected static function readUTF8Char(&$str, &$pos) {
		$b = \ord($str[$pos]);
		if($b <= 127) {
			return $str[$pos];
		}
		elseif($b <= 223) {
			if($b >= 192) {
				return $str[$pos] . $str[++$pos];
			}
			else {
				throw new \OutOfBoundsException('Invalid UTF-8 character.');
			}
		}
		elseif($b <= 239) {
			return $str[$pos] . $str[++$pos] . $str[++$pos];
		}
		elseif($b <= 247) {
			return $str[$pos] . $str[++$pos] . $str[++$pos] . $str[++$pos];
		}
		throw new \OutOfBoundsException('Invalid UTF-8 character.');
	}


	public function __construct($str, $c=0) {
		$this->str = (string)$str;
		$this->len = self::buildUTF8Sum($this->str);
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
		if($offset == 0) {
			return $this->prepend($str);
		}
		if(!$this->offsetExists($offset)) {
			if($offset == $this->count()) {
				return $this->append($str);
			}
			throw new \OutOfBoundsException('The offset is not within the string.');
		}
		return new static(\mb_substr($this->str, 0, $offset, 'UTF-8') . ((string)$str) . \mb_substr($this->str, $offset, null, 'UTF-8'));
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
			$val = \preg_replace_callback(((string)$pattern) . 'u', $replacement, $this->str, $limit, $this->c);
		}
		else {
			$val = \preg_replace(((string)$pattern) . 'u', (string)$replacement, $this->str, $limit, $this->c);
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
		foreach(\preg_split(((string)$pattern) . 'u', $this->str, $limit) as $a) {
			$arr[] = new static($a);
		}
		return $arr;
	}

	public function matchRegex($pattern, int $offset=0) : ?Regex\RegexMatch {
		if(\preg_match(((string)$pattern) . 'u', $this->str, $m, PREG_OFFSET_CAPTURE, $offset)) {
			return new Regex\RegexMatch($m);
		}
		return null;
	}

	public function matchAllRegex($pattern, int $offset=0) : ?Regex\RegexMatches {
		if(\preg_match_all(((string)$pattern) . 'u', $this->str, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER, $offset)) {
			return new Regex\RegexMatches($m);
		}
		return null;
	}


	public function substr(int $start, int $length=null) : StringInterface {
		$val = \mb_substr($this->str, $start, $length, 'UTF-8');
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
		return \mb_substr($this->str, $index, 1, 'UTF-8');
	}

	public function charCodeListAt(int $offset) : ImmutableCharCodeList {
		return new ImmutableCharCodeList($this->charAt($offset));
	}

	public function charCodeAt(int $offset) : int {
		$chr = $this->charAt($offset);
		if($b <= 127) {
			return ord($chr[0]);
		}
		elseif($b <= 223) {
			if($b >= 192) {
				if($l < 2) {
					throw new \OutOfBoundsException('UTF-8 char missing');
				}
				return ($chr[0] - 192) * 64 + ($chr[1] - 128);
			}
			else {
				throw new \OutOfBoundsException('Invalid UTF-8 character.');
			}
		}
		elseif($b <= 239) {
			if($l < 3) {
				throw new \OutOfBoundsException('UTF-8 char missing');
			}
			return ($chr[0] - 224) * 4096 + ($chr[1] - 128) * 64 + ($chr[2] - 128);
		}
		elseif($b <= 247) {
			if($l < 4) {
				throw new \OutOfBoundsException('UTF-8 char missing');
			}
			return ($chr[0] - 240) * 262144 + ($chr[1] - 128) * 4096 + ($chr[2] - 128) * 64 + ($chr[3] - 128);
		}
		throw new \OutOfBoundsException('Invalid UTF-8 character.');
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
		return new static(\mb_strtoupper($this->str, 'UTF-8'));
	}

	public function toLower() : StringInterface {
		return new static(\mb_strtolower($this->str, 'UTF-8'));
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
		return \strlen($this->str);
	}

	public function equals($str) : bool {
		return $this->str == ((string)$str);
	}
	
	public function spaceship($str) : int {
		return $this->str <=> ((string)$str);
	}


	public function current() {
		return $this->cur;
	}

	public function key() {
		return $this->kpos;
	}

	public function next() {
		if($this->pos < $this->byteLength()) {
			$this->cur = self::readUTF8Char($this->str, $this->pos);
		}
		$this->pos++;
		$this->kpos++;
	}

	public function rewind() {
		$this->kpos = 0;
		$this->pos = 0;
		$this->cur = self::readUTF8Char($this->str, $this->pos);
		$this->pos++;
	}

	public function valid() {
		return $this->pos < $this->byteLength() + 1;
	}

	public function count() {
		return $this->len;
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
		return \mb_substr($this->str, $offset, 1, 'UTF-8');
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

