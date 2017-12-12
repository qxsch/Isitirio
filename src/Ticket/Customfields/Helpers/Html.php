<?php

namespace Isitirio\Ticket\Customfields\Helpers;

use Isitirio\Ticket\Customfields\AbstractCustomfield;

class Html {
	protected static function getValidName($value){
		// from https://stackoverflow.com/questions/3158274/what-would-be-a-regex-for-valid-xml-names
		$validStartNameChar = '[A-Z]|_|[a-z]|[\xC0-\xD6]|[\xD8-\xF6]|[\xF8-\x{2FF}]|[\x{370}-\x{37D}]|[\x{37F}-\x{1FFF}]|'.
		'[\x{200C}-\x{200D}]|[\x{2070}-\x{218F}]|[\x{2C00}-\x{2FEF}]|[\x{3001}-\x{D7FF}]|[\x{F900}-\x{FDCF}]|[\x{FDF0}-\x{FFFD}]';
		$validNameChar = $validStartNameChar . '|\-|\.|[0-9]|\xB7|[\x{300}-\x{36F}]|[\x{203F}-\x{2040}]';
		$valueClean = preg_replace('/(?!'.$validNameChar.')./u','',$value);
		$firstChar = mb_substr($valueClean,0,1);
		if (!(strlen(preg_replace('/(?!'.$validStartNameChar.')./u','',$firstChar))>0)){
			$return = '_' . ((string)$valueClean);
		} else {
			$return = (string)$valueClean;
		}
		return $return;
	}

	protected function getValueAsEscapedString(AbstractCustomfield $cf, $value) {
		if($value === null) {
			$value = $cf->getValue();
		}
		return htmlspecialchars($value);
	}

	public static function Text(AbstractCustomfield $cf, $value=null) {
		return '<div>' . nl2br(self::getValueAsEscapedString($cf, $value)) . '</div>';
	}

	public static function Textarea(AbstractCustomfield $cf, $value=null, array $attributes=array()) {
		$html = '<textarea name="icf_' . $cf->getId() . '"';
		foreach($attributes as $k => $v) {
			$html .= ' ' . self::getValidName($k);
			if($v!==null) {
				$html .= '="' . htmlspecialchars($v) . '"';
			}
			$html .= ' ';
		}
		$html .= '>';
		$html .= self::getValueAsEscapedString($cf, $value);
		$html .= '</textarea>';
		return $html;
	}

	public static function Input(AbstractCustomfield $cf, $value=null, array $attributes=array()) {
		$html = '<input name="icf_' . $cf->getId() . '" value="' . self::getValueAsEscapedString($cf, $value) . '" ';
		foreach($attributes as $k => $v) {
			$html .= self::getValidName($k);
			if($v!==null) {
				$html .= '="' . htmlspecialchars($v) . '"';
			}
			$html .= ' ';
		}
		$html .= '/>';
		return $html;
	}
}
