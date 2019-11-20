<?php

namespace Isitirio;

class Defaults {
	private static $timezone = null;

	public static function setTimeZone(\DateTimeZone $timezone) {
		self::$timezone = $timezone;
	}

	public static function getTimeZone() : ?\DateTimeZone {
		return self::$timezone;
	}
}

