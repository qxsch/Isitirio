<?php

namespace Isitirio;

use Symfony\Component\Yaml\Yaml as YamlParser,
    OutOfBoundsException,
    ArrayAccess,
    IteratorAggregate,
    Countable;

class Yaml implements ArrayAccess, IteratorAggregate, Countable {
	private $yaml;

	protected function __construct() {
		$this->yaml = new \ArrayObject();
	}

	public static function createFromYamlFile(string $filename, int $flags = 0) {
		return self::createFromArray(YamlParser::parseFile($filename, $flags));
	}

	public static function createFromYamlString(string $input, int $flags = 0) {
		return self::createFromArray(YamlParser::parse($input, $flags));
	}


	public static function createFromArray(array $array) {
		$yaml = new Yaml();
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$yaml[$key] = self::createFromArray($val);
			}
			else {
				$yaml[$key] = $val;
			}
		}
		return $yaml;
	}

	public function get($yamlQuery) {
		$patterns=preg_split('@(?<!\\\)\.@', $yamlQuery);
		$node = $this->yaml;
		$keys = array();
		foreach($patterns as $key) {
			$keys[] = $key;
			$key = str_replace('\.', '.', $key);
			
			if($node instanceof ArrayAccess && $node->offsetExists($key)) {
				$node = $node->offsetGet($key);
			}
			elseif(isset($node[$key])) {
				$node = $node[$key];
			}
			else {
				throw new OutOfBoundsException('The key "' . $key . '" in the path "' . implode('.', $keys) . '" does not exist.'); 
			}
		}
		return $node;
	}

	public function tryGet($yamlQuery) {
		try {
			return $this->get($yamlQuery);
		}
		catch(OutOfBoundsException $e) {
			return null;
		}
	}

	public function has($yamlQuery) : bool {
		try {
			$this->get($yamlQuery);
			return true;
		}
		catch(OutOfBoundsException $e) {
			return false;
		}
	}

	public function dump(bool $vardump=false, int $indent=0) {
		$s = '';
		$iStr = str_repeat("   ", $indent);
		foreach($this->yaml as $key => $value) {
			$s .= $iStr . $key . ' => ';
			if($value instanceof Yaml) {
				$s .= "\n" . rtrim($value->dump($vardump, $indent + 1));
			}
			else {
				if($vardump) {
					if(ob_start()) {
						var_dump($value);
						$value = ob_get_clean();
					}
					
				}
				$s .= str_replace("\n", "\n" . $iStr . str_repeat(' ', strlen($key) + 4), rtrim($value));
			}
			$s .= "\n";

		}
		return $s;
	}

	public function count() {
		return $this->yaml->count();
	}
	public function getIterator() {
		return $this->yaml->getIterator();
	}
	public function offsetExists($offset) {
		return $this->yaml->offsetExists($offset);
	}
	public function offsetGet($offset) {
		return $this->yaml->offsetGet($offset);
	}
	public function offsetSet($offset, $value) {
		return $this->yaml->offsetSet($offset, $value);
	}
	public function offsetUnset($offset) {
		return $this->yaml->offsetUnset($offset);
	}

}
