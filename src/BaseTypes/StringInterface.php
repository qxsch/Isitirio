<?php
namespace Isitirio\BaseTypes;

interface StringInterface extends \Countable, \Iterator, \ArrayAccess {
	public function get() : string;

	public function getLastOperationCount() : int;

	public function prepend($str) : StringInterface;

	public function append($str) : StringInterface;

	public function insertAt(int $offset, $str) : StringInterface;

	public function trim($mask=null) : StringInterface;

	public function ltrim($mask=null) : StringInterface;

	public function rtrim($mask=null) : StringInterface;

	public function replace($pattern, $replacement) : StringInterface;

	public function replaceRegex($pattern, $replacement, int $limit=-1) : StringInterface;

	public function matchRegex($pattern, int $offset=0) : ?Regex\Match;

	public function matchAllRegex($pattern, int $offset=0) : ?Regex\Matches;

	public function substr(int $start, int $length=null) : StringInterface;

	public function substring(int $start, int $length=null) : StringInterface;

	public function explode($delimiter, int $limit = PHP_INT_MAX) : array;

	public function split($delimiter, int $limit = PHP_INT_MAX) : array;

	public static function implode($glue, array $pieces) : StringInterface;

	public function join(array $pieces) : StringInterface;

	public function charAt(int $offset) : string;

	public function charCodeAt(int $offset) : int;

	public function charCodeListAt(int $offset) : ImmutableCharCodeList;

	/**
	 * Does the string contain another string
	 * @param string|StringInterface|array $needle the haystack should contain (array of multiple needles is supported, where at least one must be found)
	 * @return bool true in case the haystack starts with needle
	 */
	public function contains($needle) : bool;

	/**
	 * Does the string start with another string?
	 * @param string|StringInterface $needle the haystack should begin with
	 * @return bool true in case the haystack starts with needle
	 */
	public function startsWith($needle) : bool;

	/**
	 * Does the string end with another string?
	 * @param string|StringInterface $needle the haystack should end with
	 * @return bool true in case the haystack ends with needle
	 */
	public function endsWith($needle) : bool;

	public function toUpper() : StringInterface;

	public function toLower() : StringInterface;

	/**
	 * Get the length of the string in bytes
	 *
	 * ATTETION FOR MULTIBYTE CHARSET ENCODINGS:
	 *     to get the length the string in locigal chars,
	 *     use the count method
	 * @return int the length of the string in bytes
	 */
	public function byteLength() : int;

	public function equals($str) : bool;
	
	public function spaceship($str) : int;
 
	public function __toString();
}

