<?php
namespace Isitirio\Markdown;

class Markdown extends \ParseDown {
	private $baseImagePath = '';

	public function getBaseImagePath() : string {
		return $this->baseImagePath;
	}

	public function setBaseImagePath(string $baseImagePath) {
		$this->baseImagePath = $baseImagePath;
		return $this;
	}

	protected function inlineImage($excerpt) {
		if($this->baseImagePath == '') {
			return parent::inlineImage($excerpt);
		}

		$image = parent::inlineImage($excerpt);

		if (!isset($image)) {
			return null;
		}

		$image['element']['attributes']['src'] = $this->baseImagePath . $image['element']['attributes']['src'];

		return $image;
	}

}

